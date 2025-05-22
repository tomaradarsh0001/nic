<?php
namespace App\Http\Controllers\logistic;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\LogisticItem;
use App\Models\LogisticCategory;
use App\Models\User;
use App\Models\LogisticsStockHistory;
use App\Models\LogisticRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function create()
    {
        $logisticItems = LogisticItem::with('availableStock')->where('status', 'active')->get();
        $logisticCategories = LogisticCategory::all();
        $users = User::all();

        $availableUnits = [];
        foreach ($logisticItems as $item) {
            $availableStock = $item->availableStock;
            if (!$availableStock) {
                $availableUnits[$item->id] = 0;
                continue;
            }

            $availableUnitsForItem = $availableStock->available_units;

            $latestPendingRequest = LogisticRequestItem::where('logistic_items_id', $item->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($latestPendingRequest) {
                if ($availableUnitsForItem == $latestPendingRequest->available_units) {
                    $availableAfterRequest = $latestPendingRequest->available_after_request;
                } else {
                    $pendingRequestsTotalUnits = LogisticRequestItem::where('logistic_items_id', $item->id)
                        ->where('status', 'pending')
                        ->sum('requested_units');
                    $availableAfterRequest = $availableUnitsForItem - $pendingRequestsTotalUnits;
                }
            } else {
                $availableAfterRequest = $availableUnitsForItem;
            }

            $availableUnits[$item->id] = $availableAfterRequest;
        }

        $logisticItemsWithCategories = $logisticItems->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'category_id' => $item->category_id
            ];
        });

        return view('logistics.issueItem.create', compact('logisticItems', 'logisticCategories', 'users', 'availableUnits', 'logisticItemsWithCategories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.logistic_items_id' => 'required|exists:logistic_items,id',
            'items.*.category_id' => 'required|exists:logistic_categories,id',
            'items.*.issued_units' => 'required|integer|min:1',
            'items.*.user_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();

        foreach ($validated['items'] as $item) {
            $logisticItem = LogisticItem::findOrFail($item['logistic_items_id']);
            $availableStock = $logisticItem->availableStock;

            if ($availableStock->available_units < $item['issued_units']) {
                return back()->withErrors(['items' => 'Issued units cannot exceed available units.'])->withInput();
            }

            $lastUnits = $availableStock->available_units;
            $newAvailableUnits = $availableStock->available_units - $item['issued_units'];
            $newUsedUnits = $availableStock->used_units + $item['issued_units'];

            // Fetch last issued and reduced entries
                $lastIssuedEntry = LogisticsStockHistory::where('logistic_items_id', $item['logistic_items_id'])
                    ->whereNotNull('issued_units')
                    ->latest()
                    ->first();
           
                $lastReducedEntry = LogisticsStockHistory::where('logistic_items_id', $item['logistic_items_id'])
                    ->whereNotNull('reduced_unit')
                    ->latest()
                    ->first();
           
            // Determine the latest entry between issued and reduced
                if ($lastIssuedEntry && $lastReducedEntry) {
                    $lastEntry = $lastIssuedEntry->issued_at > $lastReducedEntry->created_at ? $lastIssuedEntry : $lastReducedEntry;
                } else {
                    $lastEntry = $lastIssuedEntry ?: $lastReducedEntry;
                }
           
            $lastReducedUnits = $lastEntry ? ($lastEntry->issued_units ?? $lastEntry->reduced_unit) : 0;
            $lastReducedDate = $lastEntry ? $lastEntry->created_at : null;

            $availableStock->available_units = $newAvailableUnits;
            $availableStock->used_units = $newUsedUnits;
            $availableStock->save();

            LogisticsStockHistory::create([
                'logistic_items_id' => $item['logistic_items_id'],
                'category_id' => $item['category_id'],
                'available_units' => $newAvailableUnits,
                'last_units' => $lastUnits,
                'last_reduced_units' => $lastReducedUnits,
                'last_reduced_date' => $lastReducedDate,
                'issued_units' => $item['issued_units'],
                'issued_to_user_id' => $item['user_id'],
                'issued_by' => $userId,
                'issued_at' => now(),
                'action' => 'issued',
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);


            // Add logtistic issued item record into user action logs - lalit (24/10/2024)
            $logisticItemCategory = LogisticCategory::findOrFail($item['category_id']);
            $userDetails = User::find($item['user_id']);
            $link = "Logistic item {$logisticItem->name} ( {$logisticItemCategory->name}) has been issued to {$userDetails->name} by " . Auth::user()->name . ".";
            UserActionLogHelper::UserActionLog('update', url("/logistic/requested-items"), 'itemIssued', $link);
        }

        return redirect()->route('requested_item.index')->with('success', 'Items have been issued successfully.');
    }

}

