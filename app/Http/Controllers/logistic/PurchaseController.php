<?php

namespace App\Http\Controllers\logistic;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\LogisticAvailableStock;
use App\Models\LogisticCategory;
use App\Models\LogisticItem;
use App\Models\LogisticsStockHistory;
use App\Models\Purchase;
use App\Models\SupplierVendorDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CommonService;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*public function index()
    {
        $purchases = Purchase::with('logisticItem')
            ->select('purchase_id', 'purchased_date')
            ->groupBy('purchase_id', 'purchased_date')
            ->get()
            ->map(function ($purchase) {
                $purchase->items = Purchase::where('purchase_id', $purchase->purchase_id)->get();
                return $purchase;
            });

        return view('logistics.purchase.index', ['purchases' => $purchases]);
    }*/

    public function index()
    {
        return view('logistics.purchase.indexDatatable');
    }

    public function getPurchaseItems(Request $request)
    {
        // Start the query with the relationship and select specific columns
        $query = Purchase::with('logisticItem')
            ->select('purchase_id', 'purchased_date')
            ->groupBy('purchase_id', 'purchased_date');

        // List only actual database columns here
        $columns = ['purchase_id', 'purchased_date'];

        // Apply searching
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('purchase_id', 'LIKE', "%{$search}%")
                    ->orWhere('purchased_date', 'LIKE', "%{$search}%");
            });
        }

        // Get total data count before filtering
        $totalData = $query->count();

        // Apply ordering
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? null;
        $dir = $request->input('order.0.dir', 'asc');

        if ($order) {
            $query->orderBy($order, $dir);
        }

        // Apply pagination
        $limit = $request->input('length');
        $start = $request->input('start');
        $query->offset($start)->limit($limit);

        // Retrieve the results and map the items to each purchase
        $purchases = $query->get()->map(function ($purchase) {
            $purchase->items = Purchase::where('purchase_id', $purchase->purchase_id)->get();
            return $purchase;
        });

        // Get filtered data count
        $totalFiltered = $purchases->count();

        // Prepare data for response
        $data = [];
        foreach ($purchases as $row) {
            $nestedData = [];
            $items = '';

            // Prepare data for the columns
            $nestedData['purchase_id'] = $row->purchase_id;
            $nestedData['purchased_date'] = $row->purchased_date;
            $items = $row->items->map(function ($item) {
                $unit = $item->purchased_unit ?? $item->reduced_unit;
                $unitClass = $item->purchased_unit ? 'unit-green' : 'unit-red';
                return $item->logisticItem->name . ' <span class="' . $unitClass . '">(' . $unit . ')</span>';
            })->implode(', ');
            $nestedData['items'] = $items;

            // Prepare user action column with permissions
            $nestedData['action'] = auth()->user()->can('purchase.action') ?
                '<a href="' . route('purchase.edit', $row->purchase_id) . '" class="btn btn-primary px-4">Edit</a>' : '';

            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    public function create()
    {
        $purchaseItem = LogisticItem::get();
        $purchaseCategory = LogisticCategory::get();
        $purchaseVendor = SupplierVendorDetails::get();
        return view('logistics.purchase.create', compact('purchaseItem', 'purchaseCategory', 'purchaseVendor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_supplier_id' => 'required',
            'purchased_date' => 'required|date',
            'category_id' => 'required',
            'logistic_items_id' => 'required',
            'purchased_unit' => 'required|integer',
            'per_unit_cost' => 'nullable|numeric|min:0',
            'repeater.*.category_id' => 'sometimes|required',
            'repeater.*.logistic_items_id' => 'sometimes|required',
            'repeater.*.purchased_unit' => 'sometimes|required|integer|min:1',
            'repeater.*.per_unit_cost' => 'sometimes|nullable|numeric|min:0',
        ]);

        $totalCost = !empty($validated['per_unit_cost']) ? $validated['purchased_unit'] * $validated['per_unit_cost'] : 0;

        $purchaseId = $this->commonService->getUniqueID(Purchase::class, 'PR', 'purchase_id');

        $items = Purchase::create([
            'purchase_id' => $purchaseId,
            'vendor_supplier_id' => $validated['vendor_supplier_id'],
            'purchased_date' => $validated['purchased_date'],
            'category_id' => $validated['category_id'],
            'logistic_items_id' => $validated['logistic_items_id'],
            'purchased_unit' => $validated['purchased_unit'],
            'per_unit_cost' => $validated['per_unit_cost'],
            'total_cost' => $totalCost,
            'updated_by' => Auth::id(),
            'created_by' => Auth::id(),
        ]);

        // Add action logs for add new purchase item - Lalit (24/Oct/2024)
        $permission_link = '<a href="' . url("/logistic/purchase") . '" target="_blank">' . $purchaseId . '</a>';
        UserActionLogHelper::UserActionLog('create', url("/logistic/purchase"), 'purchase', "New purchase request item " . $permission_link . " has been created by " . Auth::user()->name.".");

        if (!empty($validated['repeater'])) {
            foreach ($validated['repeater'] as $repeater) {
                $repeaterTotalCost = !empty($repeater['per_unit_cost']) ? $repeater['purchased_unit'] * $repeater['per_unit_cost'] : 0;
                // Create Purchase record
                $purchase = Purchase::create([
                    'purchase_id' => $purchaseId,
                    'vendor_supplier_id' => $validated['vendor_supplier_id'],
                    'purchased_date' => $validated['purchased_date'],
                    'category_id' => $repeater['category_id'],
                    'logistic_items_id' => $repeater['logistic_items_id'],
                    'purchased_unit' => $repeater['purchased_unit'],
                    'per_unit_cost' => $repeater['per_unit_cost'],
                    'total_cost' => $repeaterTotalCost,
                    'updated_by' => Auth::id(),
                    'created_by' => Auth::id(),
                ]);

                // Update or Create LogisticAvailableStock
                $stock = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->first();

                if ($stock) {
                    $stock->available_units += $repeater['purchased_unit'];
                    $stock->save();
                } else {
                    LogisticAvailableStock::create([
                        'logistic_items_id' => $repeater['logistic_items_id'],
                        'available_units' => $repeater['purchased_unit'],
                        'used_units' => 0,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }

                // Fetch updated available_units for history
                $newGrossTotal = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->pluck('available_units')->first();

                // Create LogisticsStockHistory
                LogisticsStockHistory::create([
                    'logistic_items_id' => $repeater['logistic_items_id'],
                    'category_id' => $repeater['category_id'],
                    'purchase_id' => $purchase->id,
                    'purchase_unique_id' => $purchase->purchase_id,
                    'available_units' => $newGrossTotal,
                    'last_units' => $newGrossTotal - $repeater['purchased_unit'],
                    'last_added_units' => $repeater['purchased_unit'],
                    'last_added_date' => $validated['purchased_date'],
                    'issued_by' => Auth::id(),
                    'issued_at' => now(),
                    'action' => 'purchase',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
        }

        $stock = LogisticAvailableStock::where('logistic_items_id', $items->logistic_items_id)->first();

        if ($stock) {
            $stock->available_units += $items->purchased_unit;
            $stock->save();
        } else {
            LogisticAvailableStock::create([
                'logistic_items_id' => $items->logistic_items_id,
                'available_units' => $items->purchased_unit,
                'used_units' => 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        $logisticAvailableStock = LogisticAvailableStock::where('logistic_items_id', $request->logistic_items_id)->pluck('available_units');
        if ($logisticAvailableStock) {
            $newGrossTotal = $logisticAvailableStock[0];

            LogisticsStockHistory::create([
                'logistic_items_id' => $items->logistic_items_id,
                'category_id' => $items->category_id,
                'purchase_id' => $items->id,
                'purchase_unique_id' => $items->purchase_id,
                'available_units' => $newGrossTotal,
                'last_units' => $newGrossTotal - $items->purchased_unit,
                'last_added_units' => $items->purchased_unit,
                'last_added_date' => $items->purchased_date,
                'issued_by' => Auth::id(),
                'issued_at' => now(),
                'action' => 'purchase',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        return redirect()->route('purchase.index')->with('success', 'Logistic Purchase successfully.');
    }

    /*public function indexHistory()
    {
        $history = LogisticsStockHistory::all();
        return view('logistics.history.index', ['history' => $history]);
    }*/

    public function indexHistory()
    {
        return view('logistics.history.indexDatatable');
    }

    public function getLogisticHistories(Request $request)
    {
        // Start query with the correct relationship
        $query = LogisticsStockHistory::query()
            ->select('logistic_stock_histories.*');

        // List only actual database columns here
        $columns = [
            'logistic_items_id',
            'category_id',
            'purchase_id',
            'purchase_unique_id',
            'request_id',
            'request_unique_id',
            'available_units',
            'reduced_unit',
            'last_units',
            'last_added_units',
            'last_added_date',
            'last_reduced_units',
            'last_reduced_date',
            'issued_units',
            'issued_to_user_id',
            'issued_by',
            'issued_at',
            'action',
            'created_at'
        ];

        // Apply searching
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('logistic_stock_histories.purchase_id', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.purchase_unique_id', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.request_id', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.request_unique_id', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.available_units', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.reduced_unit', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.last_units', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.last_added_units', 'LIKE', "%{$search}%")
                    ->orWhere('logistic_stock_histories.last_reduced_units', 'LIKE', "%{$search}%")
                    ->orWhereHas('logisticItem', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('logisticCategory', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('issuedToUser', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('issuedBy', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Get total data and filtered data counts
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Apply ordering
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'created_at'; // Default to 'created_at'
        $dir = $request->input('order.0.dir', 'desc'); // Default to 'desc'

        // Order by created_at descending by default
        if (empty($orderColumnIndex)) {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy($order, $dir);
        }

        // Apply pagination
        $limit = $request->input('length');
        $start = $request->input('start');
        $stockData = $query->offset($start)->limit($limit)->get();

        $data = [];
        foreach ($stockData as $row) {
            $nestedData = [];

            // Prepare data for the columns
            $nestedData['logistic_item'] = $row->logisticItem->name ?? '';
            $nestedData['category'] = $row->logisticCategory->name ?? '';
            $nestedData['purchase_id'] = $row->purchase ? $row->purchase->purchase_id : '';
            $nestedData['request_id'] = $row->logisticRequest ? $row->logisticRequest->request_id : '';
            $nestedData['available_units'] = $row->available_units;
            $nestedData['reduced_units'] = $row->purchase ? $row->purchase->reduced_unit : '';
            $nestedData['last_units'] = $row->last_units;
            $nestedData['last_added_units'] = $row->last_added_units;
            $nestedData['last_added_date'] = $row->last_added_date ? Carbon::parse($row->last_added_date)->format('d/m/Y') : '';
            $nestedData['last_reduced_units'] = $row->last_reduced_units ?? '';
            $nestedData['last_reduced_date'] = $row->last_reduced_date ? Carbon::parse($row->last_reduced_date)->format('d/m/Y') : '';
            $nestedData['issued_units'] = $row->issued_units ?? '';
            $nestedData['issued_to_users'] = $row->issuedToUser->name ?? '';
            $nestedData['issued_by'] = $row->issuedBy->name ?? '';
            $nestedData['issued_at'] = $row->issued_at ? Carbon::parse($row->issued_at)->format('d/m/Y H:i:s') : '';
            $nestedData['action'] = $row->action;
            $nestedData['created_at'] = $row->created_at ? Carbon::parse($row->created_at)->format('d/m/Y H:i:s') : '';

            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    public function stockIndex()
    {
        $available = LogisticAvailableStock::all();
        return view('logistics.available.index', ['available' => $available]);
    }

    public function edit($purchaseId)
    {
        $purchaseItems = Purchase::where('purchase_id', $purchaseId)->with(['SupplierVendorDetails', 'logisticCategory', 'logisticItem'])->get();
        $purchaseItem = LogisticItem::all();
        $purchaseCategory = LogisticCategory::all();
        $purchaseVendor = SupplierVendorDetails::all();

        return view('logistics.purchase.edit', compact('purchaseItems', 'purchaseItem', 'purchaseCategory', 'purchaseVendor', 'purchaseId'));
    }

    public function getAvailableUnits($logisticItemId)
    {
        $availableStock = LogisticAvailableStock::where('logistic_items_id', $logisticItemId)->first();
        return response()->json(['available_units' => $availableStock ? $availableStock->available_units : 0]);
    }


    public function update(Request $request, $purchaseId)
    {
        $validated = $request->validate([
            'vendor_supplier_id' => 'required',
            'purchased_date' => 'required|date',
            'repeater.*.category_id' => 'sometimes|required',
            'repeater.*.logistic_items_id' => 'sometimes|required',
            'repeater.*.purchased_unit' => 'sometimes|nullable|integer|min:1',
            'repeater.*.reduced_unit' => 'sometimes|nullable|integer|min:1',
            'repeater.*.per_unit_cost' => 'sometimes|nullable|numeric|min:0',
        ]);

        foreach ($request->input('repeater', []) as $index => $repeater) {
            if (empty($repeater['purchased_unit']) && empty($repeater['reduced_unit'])) {
                return back()->withErrors(['repeater.' . $index . '.purchased_unit' => 'Either purchased unit or reduced unit must be entered.'])
                    ->withInput();
            }
        }

        if (!empty($validated['repeater'])) {
            foreach ($validated['repeater'] as $repeater) {
                if (!empty($repeater['purchased_unit']) && !empty($repeater['reduced_unit'])) {
                    continue;
                }

                if (!empty($repeater['purchased_unit'])) {
                    $totalCost = !empty($repeater['per_unit_cost']) ? $repeater['purchased_unit'] * $repeater['per_unit_cost'] : 0;
                    $newItem = Purchase::create([
                        'purchase_id' => $purchaseId,
                        'vendor_supplier_id' => $validated['vendor_supplier_id'],
                        'purchased_date' => $validated['purchased_date'],
                        'category_id' => $repeater['category_id'],
                        'logistic_items_id' => $repeater['logistic_items_id'],
                        'purchased_unit' => $repeater['purchased_unit'],
                        'reduced_unit' => null,
                        'per_unit_cost' => $repeater['per_unit_cost'],
                        'total_cost' => $totalCost,
                        'updated_by' => Auth::id(),
                        'created_by' => Auth::id(),
                    ]);

                    // Add action logs for add new purchase item - Lalit (24/Oct/2024)
                    $permission_link = '<a href="' . url("/logistic/purchase") . '" target="_blank">' . $purchaseId . '</a>';
                    UserActionLogHelper::UserActionLog('create', url("/logistic/purchase"), 'purchase', "New purchase request item " . $permission_link . " has been created by " . Auth::user()->name.".");

                    // Update or create available stock
                    $stock = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->first();
                    if ($stock) {
                        $stock->available_units += $repeater['purchased_unit'];
                        $stock->save();
                    } else {
                        LogisticAvailableStock::create([
                            'logistic_items_id' => $repeater['logistic_items_id'],
                            'available_units' => $repeater['purchased_unit'],
                            'used_units' => 0,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }

                    // Create stock history
                    $newGrossTotal = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->pluck('available_units')->first();

                    LogisticsStockHistory::create([
                        'logistic_items_id' => $repeater['logistic_items_id'],
                        'category_id' => $repeater['category_id'],
                        'purchase_id' => $newItem->id,
                        'purchase_unique_id' => $newItem->purchase_id,
                        'available_units' => $newGrossTotal,
                        'last_units' => $newGrossTotal - $repeater['purchased_unit'],
                        'last_added_units' => $repeater['purchased_unit'],
                        'last_added_date' => $validated['purchased_date'],
                        'issued_by' => Auth::id(),
                        'issued_at' => now(),
                        'action' => 'purchase',
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }

                if (!empty($repeater['reduced_unit'])) {
                    $totalCost = 0;

                    $newItem = Purchase::create([
                        'purchase_id' => $purchaseId,
                        'vendor_supplier_id' => $validated['vendor_supplier_id'],
                        'purchased_date' => $validated['purchased_date'],
                        'category_id' => $repeater['category_id'],
                        'logistic_items_id' => $repeater['logistic_items_id'],
                        'purchased_unit' => null,
                        'reduced_unit' => $repeater['reduced_unit'],
                        'per_unit_cost' => $repeater['per_unit_cost'],
                        'total_cost' => $totalCost,
                        'updated_by' => Auth::id(),
                        'created_by' => Auth::id(),
                    ]);

                    // Add action logs for add new purchase item - Lalit (24/Oct/2024)
                    $permission_link = '<a href="' . url("/logistic/purchase") . '" target="_blank">' . $purchaseId . '</a>';
                    UserActionLogHelper::UserActionLog('create', url("/logistic/purchase"), 'purchase', "New purchase request item " . $permission_link . " has been created by " . Auth::user()->name.".");

                    // Update available stock
                    $stock = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->first();
                    if ($stock) {
                        $stock->available_units -= $repeater['reduced_unit'];
                        $stock->save();
                    }

                    // Fetch last issued and reduced entries
                    $lastIssuedEntry = LogisticsStockHistory::where('logistic_items_id', $repeater['logistic_items_id'])
                        ->whereNotNull('issued_units')
                        ->latest()
                        ->first();

                    $lastReducedEntry = LogisticsStockHistory::where('logistic_items_id', $repeater['logistic_items_id'])
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

                    // Create stock history
                    $newGrossTotal = LogisticAvailableStock::where('logistic_items_id', $repeater['logistic_items_id'])->pluck('available_units')->first();

                    LogisticsStockHistory::create([
                        'logistic_items_id' => $repeater['logistic_items_id'],
                        'category_id' => $repeater['category_id'],
                        'purchase_id' => $newItem->id,
                        'purchase_unique_id' => $newItem->purchase_id,
                        'available_units' => $newGrossTotal,
                        'reduced_unit' => $repeater['reduced_unit'],
                        'last_units' => $newGrossTotal + $repeater['reduced_unit'],
                        'last_reduced_units' => $lastReducedUnits,
                        'last_reduced_date' => $lastReducedDate,
                        'issued_by' => Auth::id(),
                        'issued_at' => now(),
                        'action' => 'purchase',
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }
            }
        }

        return redirect()->route('purchase.index')->with('success', 'Logistic Purchase updated successfully.');
    }

    public function destroy($id)
    {
        $item = Purchase::find($id);
        $item->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase Deleted Successfully');
    }
}
