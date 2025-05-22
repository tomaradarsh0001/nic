<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LogisticAvailableStock;
use App\Models\LogisticCategory;
use App\Models\LogisticItem;
use App\Models\LogisticRequestItem;
use Illuminate\Http\Request;
use App\Models\LogisticsStockHistory;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

     //API updated by adarsh tomar on 07 sept 2024
    public function store(Request $request)
    {
        $rules = [
            'items' => 'required|array|min:1',
            'items.*.logistic_items_id' => 'required|exists:logistic_items,id',
            'items.*.category_id' => 'required|exists:logistic_categories,id',
            'items.*.requested_units' => 'required|integer|min:1',
        ];

        $messages = [
            'items.required' => 'At least one item is required.',
            'items.array' => 'Items must be an array.',
            'items.min' => 'At least one item is required.',
            'items.*.logistic_items_id.required' => 'Logistic item ID is required.',
            'items.*.logistic_items_id.exists' => 'Invalid item or category.',
            'items.*.category_id.required' => 'Category ID is required.',
            'items.*.category_id.exists' => 'Invalid item or category.',
            'items.*.requested_units.required' => 'Requested units are required.',
            'items.*.requested_units.integer' => 'Requested units must be an integer.',
            'items.*.requested_units.min' => 'Requested units must be at least 1.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $customErrors = implode(' ', $errors->all());

            return response()->json([
                'message' => 'Invalid input parameters.',
                'error' => $customErrors,
                'data' => null
            ], 422); 
        }

        $validated = $validator->validated();
        $requestId = $this->commonService->getUniqueID(LogisticRequestItem::class, 'RQ', 'request_id');
        $userId = Auth::id();

        $responses = [];

        foreach ($validated['items'] as $item) {
            $availableStock = LogisticAvailableStock::where('logistic_items_id', $item['logistic_items_id'])->first();

            if (!$availableStock) {
                return response()->json([
                    'message' => 'Logistic item not found in available stock.',
                    'error' => 'Invalid item.'
                ], 404);
            }

            $availableUnits = $availableStock->available_units;

            $latestPendingRequest = LogisticRequestItem::where('logistic_items_id', $item['logistic_items_id'])
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($latestPendingRequest) {
                if ($availableUnits == $latestPendingRequest->available_units) {
                    $availableAfterRequest = $latestPendingRequest->available_after_request - $item['requested_units'];
                } else {
                    $pendingRequestsTotalUnits = LogisticRequestItem::where('logistic_items_id', $item['logistic_items_id'])
                        ->where('status', 'pending')
                        ->sum('requested_units');
                    $availableAfterRequest = $availableUnits - ($pendingRequestsTotalUnits + $item['requested_units']);
                }
            } else {
                $availableAfterRequest = $availableUnits - $item['requested_units'];
            }

            if ($availableAfterRequest < 0) {
                return response()->json([
                    'message' => 'Request Unsuccessful',
                    'error' => 'Requested units exceed available stock.'
                ], 400);
            }

            $userRequest = LogisticRequestItem::create([
                'request_id' => $requestId,
                'logistic_items_id' => $item['logistic_items_id'],
                'category_id' => $item['category_id'],
                'available_units' => $availableUnits,
                'requested_units' => $item['requested_units'],
                'available_after_request' => $availableAfterRequest,
                'issued_units' => NULL,
                'status' => 'pending',
                'created_by' => $userId,
            ]);

            $responses[] = $userRequest->toArray();
        }

        foreach ($responses as &$responseItem) {
            $responseItem['issued_units'] = $responseItem['issued_units'] ?? '';
        }

        return response()->json([
            'message' => 'Request submitted successfully.',
            'requests' => $responses
        ], 200);
    }


    public function requestHistory()
    {
        $userId = Auth::id();
        $requests = LogisticRequestItem::where('created_by', $userId)
            ->with(['logisticItem', 'category'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('request_id');
    
        if ($requests->isEmpty()) {
            return response()->json([
                'message' => 'Item Requsets fetching Unsuccessfull',
                'user-requests' => 'No requests are found.'
            ], 200);
        }
    
        $response = [];
    
        foreach ($requests as $requestId => $items) {
            $firstItem = $items->first();
    
            $pendingDate = $firstItem->created_at->toDateTimeString();
    
            $issuedDate = LogisticsStockHistory::where('request_id', $firstItem->id)
                ->where('action', 'issued')
                ->latest()
                ->value('issued_at');
            $issuedDate = $issuedDate ? Carbon::parse($issuedDate)->toDateTimeString() : '';
    
            $rejectedDate = $items->where('status', 'Rejected')->first();
            $rejectedDate = $rejectedDate ? $rejectedDate->updated_at->toDateTimeString() : '';
    
            $status = $firstItem->status;
    
            $totalRequestedUnits = $items->sum('requested_units');
            $totalIssuedUnits = $items->sum('issued_units');
    
            $itemDetails = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'logistic_item_name' => $item->logisticItem->name,
                    'category_name' => $item->category->name,
                    'requested_units' => $item->requested_units,
                    'issued_units' => $item->issued_units,
                ];
            });
    
            $response[] = [
                'request_id' => $requestId,
                'requested_date' => $pendingDate, 
                'status' => $status,
                'issued_date' => $issuedDate,
                'rejected_date' => $rejectedDate,
                'total_requested_units' => $totalRequestedUnits,
                'total_issued_units' => $totalIssuedUnits,
                'items' => $itemDetails,
            ];
        }
    
        return response()->json([
            'message' => 'Item Requests Successfully fetched.',
            'user-requests' => $response
        ], 200);
    }
    

    // Update Pending Request API SwatiMishra 17-07-2024, 5:00 PM

    public function update(Request $request, $requestId)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.logistic_items_id' => 'required|exists:logistic_items,id',
            'items.*.category_id' => 'required|exists:logistic_categories,id',
            'items.*.requested_units' => 'required|integer|min:1',
        ]);
    
        $userId = Auth::id();
    
        $logisticRequestItems = LogisticRequestItem::where('request_id', $requestId)
            ->where('created_by', $userId)
            ->where('status', 'pending')
            ->get();
    
        if ($logisticRequestItems->isEmpty()) {
            return response()->json(['error' => 'Request not found or not in pending status.'], 404);
        }
    
        $existingItemIds = $logisticRequestItems->pluck('logistic_items_id')->toArray();
        $newItemIds = collect($validated['items'])->pluck('logistic_items_id')->toArray();
    
        $itemsToDelete = array_diff($existingItemIds, $newItemIds);
    
        // Delete items that are no longer requested
        LogisticRequestItem::where('request_id', $requestId)
            ->whereIn('logistic_items_id', $itemsToDelete)
            ->delete();
    
        $responses = [];
    
        foreach ($validated['items'] as $item) {
            $logisticRequestItem = $logisticRequestItems->where('logistic_items_id', $item['logistic_items_id'])->first();
    
            $availableStock = LogisticAvailableStock::where('logistic_items_id', $item['logistic_items_id'])->first();
    
            if (!$availableStock) {
                return response()->json(['error' => 'Logistic item not found in available stock.'], 404);
            }
    
            $availableUnits = $availableStock->available_units;
    
            $latestPendingRequest = LogisticRequestItem::where('logistic_items_id', $item['logistic_items_id'])
                ->where('status', 'pending')
                ->where('id', '!=', $logisticRequestItem ? $logisticRequestItem->id : 0)
                ->latest()
                ->first();
    
            if ($latestPendingRequest) {
                if ($availableUnits == $latestPendingRequest->available_units) {
                    $availableAfterRequest = $latestPendingRequest->available_after_request - $item['requested_units'];
                } else {
                    $pendingRequestsTotalUnits = LogisticRequestItem::where('logistic_items_id', $item['logistic_items_id'])
                        ->where('status', 'pending')
                        ->sum('requested_units');
                    $availableAfterRequest = $availableUnits - ($pendingRequestsTotalUnits + $item['requested_units']);
                }
            } else {
                $availableAfterRequest = $availableUnits - $item['requested_units'];
            }
    
            if ($availableAfterRequest < 0) {
                return response()->json(['message' => 'Request Unsuccessfull', 'error' => 'Requested units exceed available stock.'], 400);
            }
    
            if ($logisticRequestItem) {
                $logisticRequestItem->category_id = $item['category_id'];
                $logisticRequestItem->requested_units = $item['requested_units'];
                $logisticRequestItem->available_units = $availableUnits;
                $logisticRequestItem->available_after_request = $availableAfterRequest;
                $logisticRequestItem->issued_units = NULL;
                $logisticRequestItem->save();
                $responses[] = $logisticRequestItem->toArray();
            } else {
                $newRequestItem = LogisticRequestItem::create([
                    'request_id' => $requestId,
                    'logistic_items_id' => $item['logistic_items_id'],
                    'category_id' => $item['category_id'],
                    'available_units' => $availableUnits,
                    'requested_units' => $item['requested_units'],
                    'available_after_request' => $availableAfterRequest,
                    'issued_units' => NULL,
                    'status' => 'pending',
                    'created_by' => $userId,
                ]);
                $responses[] = $newRequestItem->toArray();
            }
        }
    
        // Transform issued_units to blank in the response
        foreach ($responses as &$responseItem) {
            $responseItem['issued_units'] = $responseItem['issued_units'] ?? '';
        }
    
        return response()->json(['success' => 'Request updated successfully.', 'requests' => $responses]);
    }
}
