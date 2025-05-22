<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LogisticItem;
use App\Models\LogisticRequestItem;
use Illuminate\Http\Request;

class ItemsListController extends Controller
{
    public function getItemsDetails()
    {
        //API updated by adarsh tomar on 07 sept 2024
        $items = LogisticItem::with(['logisticCategory:id,name', 'availableStock', 'latestRequest'])
            ->select('id', 'name', 'label', 'category_id')
            ->where('status', 'active') 
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'message' => 'Failed to Fetch Items.',
                'data' => 'No items are available.'
            ], 200);
        }

        $items = $items->map(function ($item) {
            $availableUnits = $item->availableStock ? $item->availableStock->available_units : 0;

            $latestPendingRequest = LogisticRequestItem::where('logistic_items_id', $item->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($latestPendingRequest) {
                if ($availableUnits == $latestPendingRequest->available_units) {
                    $availableAfterRequest = $latestPendingRequest->available_after_request;
                } else {
                    $pendingRequestsTotalUnits = LogisticRequestItem::where('logistic_items_id', $item->id)
                        ->where('status', 'pending')
                        ->sum('requested_units');

                    $availableAfterRequest = $availableUnits - $pendingRequestsTotalUnits;
                }
            } else {
                $availableAfterRequest = $availableUnits;
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'label' => $item->label,
                'category_name' => $item->logisticCategory->name,
                'category_id' => $item->logisticCategory->id,
                'available_units' => $availableAfterRequest, 
            ];
        });

        return response()->json([
            'message' => 'Items successfully fetched.',
            'data' => $items
        ], 200);
    }
}
