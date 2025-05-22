<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\PropertyMaster;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertySectionMapping;
use App\Models\SplitedPropertyDetail;
use Illuminate\Support\Facades\DB;

class ColonyController extends Controller
{
    public function localityBlocks(Request $request)
    {
        $blocks = PropertyMaster::select('block_no')
            ->whereNotNull('block_no')
            ->where('new_colony_name', $request->locality)
            ->orderByRaw("CAST(block_no AS UNSIGNED), block_no")
            ->orderBy('block_no', 'asc') // Add ascending order for block_no
            ->distinct()
            ->get();
        return $blocks;
    }

    // Comment old code by Lalit tiwari on (18/Oct/2024)
    /*public function blockPlots(Request $request){
        // $plots = PropertyMaster::where('new_colony_name',$request->locality)->where('block_no',$request->block)->orderBy('plot_or_property_no')->distinct()->pluck('plot_or_property_no');
        $plots = PropertyMaster::where('new_colony_name', $request->locality)
                    ->where('block_no',$request->block)
                    ->get();
        $data = [];
        foreach($plots as $plot){
            if($plot->is_joint_property){
                $splited = SplitedPropertyDetail::select('plot_flat_no')->where('property_master_id',$plot->id)->get();
                // dd($splited);
                foreach($splited as $split){
                    $data[] = $split->plot_flat_no;
                }
            } else {
                $data[] = $plot->plot_or_property_no;
            }
        }

        // dd($data);

        // $data = PropertyMaster::select('plot_or_property_no')
        //             ->where('new_colony_name', $request->locality)
        //             ->where('block_no',$request->block)
        //             ->orderByRaw("CAST(plot_or_property_no AS UNSIGNED), plot_or_property_no")
        //             ->distinct()
        //             ->get();
        // dd($data);
        return array_unique($data);
        
    }*/

    // Writting new code to make order by plot_flat_no Or plot_or_property_no - Lalit tiwari on (18/Oct/2024)
    public function blockPlots(Request $request)
    {
        // Fetch all plots and split properties in a single query using relationships
        $plots = PropertyMaster::where('new_colony_name', $request->locality)
            ->where('block_no', $request->block)
            ->with(['splitedProperties' => function ($query) {
                $query->select('plot_flat_no', 'property_master_id')
                    ->orderByRaw('CAST(plot_flat_no AS UNSIGNED) ASC'); // Ensure proper numerical ordering for split properties
            }])
            ->orderByRaw('CAST(plot_or_property_no AS UNSIGNED) ASC') // Ensure proper numerical ordering for non-split properties
            ->get();

        $data = [];

        foreach ($plots as $plot) {
            // If the plot is a joint property, fetch the ordered split properties
            if ($plot->is_joint_property) {
                foreach ($plot->splitedProperties as $split) {
                    $data[] = $split->plot_flat_no;
                }
            } else {
                $data[] = $plot->plot_or_property_no;
            }
        }

        return array_unique($data); // Return unique plot/flat numbers
    }



    public function plotKnownas(Request $request)
    {
        $property = PropertyMaster::where('new_colony_name', $request->locality)
            ->where('block_no', $request->block)
            ->where('plot_or_property_no', $request->plot)
            ->first();

        if ($property) {
            // If property is found, retrieve the presently known names
            $property_master_id = $property->id;
            $knownAs = PropertyLeaseDetail::where('property_master_id', $property_master_id)
                ->pluck('presently_known_as')
                ->toArray();  // Convert collection to array
        } else {
            // If property not found, retrieve the plot/flat numbers from Splited Property Detail table
            $knownAs = [];
            $data = SplitedPropertyDetail::where('plot_flat_no', $request->plot)
                ->get();

            foreach ($data as $known) {
                $knownAs[] = $known->plot_flat_no;
            }
        }
        return array_unique($knownAs);
    }

    public function knownAsFlat(Request $request)
    {
        $flats = [];
        if (isset($request->known_as)) {
            $getFlat = Flat::where('locality', $request->locality)
                ->where('block', $request->block)
                ->where('plot', $request->plot)
                ->where('known_as', $request->known_as)
                ->get();
        } else {
            $getFlat = Flat::where('locality', $request->locality)
                ->where('block', $request->block)
                ->where('plot', $request->plot)
                ->get();
        }

        foreach ($getFlat as $key => $flat) {
            $flats[$flat->id] = $flat->flat_number;
        }
        return array_unique($flats);
    }

    //Comment given below function by Lalit Tiwari - 13/02/2025
    /*public function landTypes(Request $request)
    {
        $colonyId = $request->locality;

        // Get active property types associated with the colony
        $propertyTypeIds = PropertySectionMapping::where('colony_id', $colonyId)
            ->where('is_active', 1)
            ->pluck('property_type')
            ->unique();

        // Fetch corresponding property type names
        $propertyTypes = Item::whereIn('id', $propertyTypeIds)
            ->get(['id', 'item_name']);

        // Get active property subtypes based on fetched property types
        $propertySubtypeIds = DB::table('property_type_sub_type_mapping')
            ->whereIn('type', $propertyTypeIds)
            ->where('is_active', 1)
            ->pluck('sub_type')
            ->unique();

        // Fetch corresponding property subtype names
        $propertySubtypes = Item::whereIn('id', $propertySubtypeIds)
            ->get(['id', 'item_name']);

        // Return response as JSON
        return response()->json([
            'propertyTypes' => $propertyTypes,
            'propertySubtypes' => $propertySubtypes,
        ]);
    }*/

    public function landTypes(Request $request)
    {
        $colonyId = $request->locality;

        // Get active property types associated with the colony
        $propertyTypeIds = PropertySectionMapping::where('colony_id', $colonyId)
            ->where('is_active', 1)
            ->pluck('property_type')
            ->unique();

        // Fetch corresponding property type names
        $propertyTypes = Item::whereIn('id', $propertyTypeIds)
            ->get(['id', 'item_name']);

        // Return response as JSON
        return response()->json(['propertyTypes' => $propertyTypes]);
    }

    public function landSubTypes(Request $request)
    {
        $colonyId = $request->locality;
        $landTypes = $request->landType;

        // Get active property types associated with the colony
        $propertySubTypeIds = PropertySectionMapping::where('colony_id', $colonyId)->where('property_type', $landTypes)->where('is_active', 1)->pluck('property_subtype')->unique();

        // Fetch corresponding property type names
        $propertySubTypes = Item::whereIn('id', $propertySubTypeIds)
            ->get(['id', 'item_name']);

        // Return response as JSON
        return response()->json(['propertySubtypes' => $propertySubTypes]);
    }

}
