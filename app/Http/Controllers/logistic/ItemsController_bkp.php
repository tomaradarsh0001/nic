<?php

namespace App\Http\Controllers\logistic;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\LogisticCategory;
use App\Models\LogisticItem;
use App\Models\LogisticRequestItem; 
use App\Models\LogisticsStockHistory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function index()
    {
        $logisticItems = LogisticItem::all();
        return view('logistics.items.index', ['items' => $logisticItems]);
    }

    public function create()
    {
        $categories = LogisticCategory::get();
        return view('logistics.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'label' => 'required|string|max:50|unique:logistic_items,label',
                'name' => 'required|string|max:100',
                'category_id' => 'required',
                'status' => 'required|in:active,inactive',
            ],
            [
                'label.unique' => 'Item already exists.', 
            ]
        );

        $logistic = LogisticItem::create([
            'label' => $request->label,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'updated_by' => Auth::id(),
            'created_by' => Auth::id(),
        ]);

        // Manage logistic item create action activity lalit on 22/07/24
        $action_link = '<a href="' . route('logistic.index') . '" target="_blank">' . $logistic->name . '</a>';
        UserActionLogHelper::UserActionLog('create', route('logistic.index'), 'logisticItems', "New logistic item " . $action_link . " has been created by " . Auth::user()->name.".");

        return redirect()->route('logistic.index')->with('success', 'Logistic item created successfully.');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('q');
        $items = LogisticItem::where('label', 'LIKE', '%' . $term . '%')->pluck('label');
        return response()->json($items);
    }

    public function edit($id)
    {
        $data = LogisticItem::findOrFail($id);
        $categories = LogisticCategory::all();
        return view('logistics.items.edit', compact('data', 'categories'));
    }

    // Method to update the data
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category_id' => 'required',
        ]);

        $data = LogisticItem::findOrFail($id);
        $data->label = $request->label;
        $data->name = $request->name;
        $data->category_id = $request->category_id;
        $data->save();
        // Manage logistic item update action activity lalit on 22/07/24
        $action_link = '<a href="' . route('logistic.index') . '" target="_blank">' . $request->name . '</a>';
        UserActionLogHelper::UserActionLog('update', route('logistic.index'), 'logisticItems', "Logistic item " . $action_link . " has been updated by " . Auth::user()->name.".");

        return redirect()->route('logistic.index')->with('success', 'Data updated successfully');
    }

    public function updatelabel(Request $request, LogisticItem $item)
    {
        if ($request->ajax()) {
            $item->find($request->pk)->update(['label' => $request->value]);
            // Manage logistic item update label name action activity lalit on 22/07/24
            $action_link = '<a href="' . route('logistic.index') . '" target="_blank">' . $request->value . '</a>';
            UserActionLogHelper::UserActionLog('update', route('logistic.index'), 'logisticItems', "Logistic item label " . $action_link . " has been updated by " . Auth::user()->name.".");
            return response()->json(['success' => true]);
        }
    }

    public function destroy($id)
    {
        $item = LogisticItem::find($id);
        if ($item->delete()) {
            // Manage logistic item delete action activity lalit on 22/07/24
            $action_link = '<a href="' . route('logistic.index') . '" target="_blank">' . $item->name . '</a>';
            UserActionLogHelper::UserActionLog('delete', route('logistic.index'), 'logisticItems', "Logistic item " . $action_link . " has been deleted by " . Auth::user()->name.".");
            return 'Item Deleted Successfully';
        } else {
            return 'Item not Deleted';
        }
    }

    public function updateStatus(Request $request, $itemId)
    {
        $item = LogisticItem::findOrFail($itemId);
        
        // Check for pending requests
        $pendingRequests = LogisticRequestItem::where('logistic_items_id', $itemId)
                                               ->where('status', 'pending')
                                               ->exists();
    
        if ($pendingRequests) {
            return redirect()->route('logistic.index')->with('failure', 'Request related to this item is pending so it cannot be deactivated');
        }
    
        $purchasedItems = LogisticsStockHistory::where('logistic_items_id', $itemId)
                                               ->where('action', 'purchase') 
                                               ->exists();
    
        if ($purchasedItems) {
            return redirect()->route('logistic.index')->with('failure', 'Item cannot be deactivated as it has already been purchased.');
        }
    
        $status = $item->status;
        $newStatus = ($status == 'active') ? 'inactive' : 'active';
        $item->status = $newStatus;
        $item->save();
    
        return redirect()->route('logistic.index')->with('success', 'Status updated successfully');
    }
    
    

}
