<?php

namespace App\Http\Controllers\logistic;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\LogisticCategory;
use App\Models\LogisticItem;
use Illuminate\Http\Request;
use Auth;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = LogisticCategory::all();
        return view('logistics.category.index', compact('categories'));

    }
    public function create()
    {
        $categories = LogisticCategory::get();
        return view('logistics.category.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:100|unique:logistic_categories,name',
                'status' => 'required|in:active,inactive',
            ]
        );

        LogisticCategory::create(
            [
                'name' => $request->name,
                'status' => $request->status,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]
        );

        // Add action logs for Create Category - Lalit (24/Oct/2024)
        $permission_link = '<a href="' . url("/logistic/category") . '" target="_blank">' . $request->name . '</a>';
        UserActionLogHelper::UserActionLog('create', url("/logistic/category"), 'logisticCategories', "New logistic category " . $permission_link . " has been created by " . Auth::user()->name.".");

        return redirect()->back()->with('success', 'Logistic Category Created successfully.');
    }
    public function checkName(Request $request)
    {
        $exists = LogisticCategory::where('name', $request->name)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function update(Request $request, LogisticCategory $category)
    {
        if ($request->ajax()) {
            $request->validate(
                [
                    'value' => 'required|string|max:100|unique:logistic_categories,name,' . $category->id,
                ],
                [
                    'value.unique' => 'Category already exists.',
                ]
            );

            $category = LogisticCategory::findOrFail($request->pk);
            $category->update(['name' => $request->value]);
            
            // Add action logs for Update Category - Lalit (24/Oct/2024)
            $permission_link = '<a href="' . url("/logistic/category") . '" target="_blank">' . $request->value . '</a>';
            UserActionLogHelper::UserActionLog('create', url("/logistic/category"), 'logisticCategories', "logistic category " . $permission_link . " has been updated by " . Auth::user()->name.".");

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400); // Return an error response if not AJAX
    }


    public function autocomplete(Request $request)
    {
        $term = $request->get('q');
        $items = LogisticCategory::where('name', 'LIKE', '%' . $term . '%')->pluck('name');
        return response()->json($items);
    }
    
   
    public function updateStatus(Request $request, $itemId)
    {
        $category = LogisticCategory::findOrFail($itemId);
    
        // Check if there are any active items under this category
        $activeItems = LogisticItem::where('category_id', $itemId)
            ->where('category_id', $itemId)
            ->where('status', 'active')
            ->count();
    
        if ($activeItems > 0) {
            return back()->with('failure', 'Cannot deactivate category with active items.');
        }
    
        // Toggle the status
        $status = $category->status;
        $newStatus = ($status == 'active') ? 'inactive' : 'active';
        $category->status = $newStatus;
        $category->save();

        // Add action logs for Update Category - Lalit (24/Oct/2024)
        $permission_link = '<a href="' . url("/logistic/category") . '" target="_blank">' . $category->name . '</a>';
        UserActionLogHelper::UserActionLog('create', url("/logistic/category"), 'logisticCategories', "logistic category status for this " . $permission_link . " has been changed as ".$newStatus." by " . Auth::user()->name.".");
    
        return back()->with('success', 'Status updated successfully.');
    }
    


}