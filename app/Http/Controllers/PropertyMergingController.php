<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ColonyService;

class PropertyMergingController extends Controller
{
    public function create(ColonyService $colonyService)
    {
        $colonyList = $colonyService->getColonyList();
        return view('property-merging.create', compact(['colonyList']));
    }

    public function getPropertyCount(Request $request)
    {
        $colonyId = $request->query('colonyId');
        if (!$colonyId) {
            return response()->json(['count' => 0]);
        }
    
        $count = \DB::table('property_masters')->where('new_colony_name', $colonyId)->count();
        return response()->json(['count' => $count]);
    }
    

    public function merge(Request $request, ColonyService $colonyService)
    {
        // Validate the request with updated field names
        $validated = $request->validate([
            'colonyToBeMerged' => 'required|exists:old_colonies,id',
            'colonyMergedWith' => 'required|exists:old_colonies,id|different:colonyToBeMerged',
        ]);
    
        // Perform the merge using the ColonyService
        $result = $colonyService->mergeColonies($validated['colonyToBeMerged'], $validated['colonyMergedWith']);
    
        if ($result) {
            return redirect()->route('colony.merger.create')->with('success', 'Colonies merged successfully!');
        } else {
            return redirect()->route('colony.merger.create')->with('error', 'Failed to merge colonies.');
        }
    }
    


}
