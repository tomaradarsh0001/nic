<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Auth;
use Illuminate\Support\Facades\Log;

class ActionController extends Controller
{
    public function index(Request $request, $id = null){
        $actions = Item::where('group_id',17002)->paginate(10);
        if ($request->routeIs('settings.action.index')) {
            return view('settings.action.index',compact(['actions']));
        } elseif ($request->routeIs('settings.action.edit')) {
            $item = Item::find($id);
            return view('settings.action.index',compact(['actions','item']));
        } else {
            return redirect()->back()->with('failure', 'Something went wrong.');
        }

    }


    public function store(Request $request){
        try {
            $item = Item::create([
                'group_id' => 17002,
                'item_name' => $request->actionName,
                'item_code' => $request->actionCode,
                'created_by' => Auth::user()->id,
            ]);
            if($item){
                return redirect()->back()->with('success', 'Action Saved successfully.');
            } else {
                return redirect()->back()->with('failure', 'Action Not Saved.');
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('failure', $e->getMessage());
        }

    }

    public function update($id, Request $request){
        $item = Item::find($id);
        if($item){
                $item->item_name = $request->actionName;
                if($item->save()){
                    return redirect()->route('settings.action.index')->with('success', 'Action updated successfully');
                } else {
                    return redirect()->back()->with('failure', "Action can't be updated, Please try after some time.");
                }
        } else {
            return redirect()->back()->with('failure', "Can't be updated as details not available.");
        }
    }

    
}
