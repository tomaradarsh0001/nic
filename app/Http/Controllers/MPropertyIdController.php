<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OldPropertId;
use App\Models\PropertyMaster;
use App\Models\OldColony;
use App\Models\SplitedPropertyDetail;
use App\Models\Item;
use App\Models\PropertySectionMapping;
use App\Models\UserRegistration;
use Illuminate\Support\Facades\Http;

class MPropertyIdController extends Controller
{

    // public function propertySearchById(Request $request)
    // {

    //     $response = Http::post('https://ldo.gov.in/eDhartiAPI/Api/GetValues/PropertyWiseStatus?EnteredPropertyID=' . $request->property_id);

    //     $jsonData = $response->json();
    //     //   dd($jsonData[0]);
    //     if ($jsonData) {
    //         // $property = OldPropertId::where('PropertyID', $request->property_id)->whereIn('Status', ['LH', 'FH', 'VT', 'OTH'])->first();

    //         $check_property_id_in_new_record = PropertyMaster::where('old_propert_id', $request->property_id)->count();

    //         if ($check_property_id_in_new_record == 0) {

    //             $colony = OldColony::colonyIdByColonyCode($jsonData[0]['ColonyCode']);
    //             $property_status = Item::getItemIdUsingItemCode($jsonData[0]['Status'], 109);
    //             $land_type = Item::getItemIdUsingItemCode($jsonData[0]['LandType'], 1051);

    //             $response = ['status' => true, 'message' => 'Property details fetched', 'data' => ['property_id' => $request->property_id, 'file_number' => $jsonData[0]['FileNumber'], 'property_status' => $property_status, 'colony_id' => $colony['0']->id, 'land_type' => $land_type]];
    //         } elseif ($check_property_id_in_new_record > 0) {
    //             $response = ['status' => false, 'message' => 'Provided Property ID is already saved.', 'data' => NULL];
    //         } else {
    //             $response = ['status' => false, 'message' => 'Provided Property ID is wrong/dulicate marked.', 'data' => NULL];
    //         }

    //         return json_encode($response);
    //     }

    // }

    public function propertySearchById(Request $request)
    {

        $response = Http::post('https://ldo.gov.in/eDhartiAPI/Api/GetValues/PropertyWiseStatus?EnteredPropertyID=' . $request->property_id);
        
        $jsonData = $response->json();
        if(isset($jsonData['Message'])){
            $response = ['status' => false, 'message' => 'Provided Property ID is not available.', 'data' => NULL];
        } else {
            // $property = OldPropertId::where('PropertyID', $request->property_id)->whereIn('Status', ['LH', 'FH', 'VT', 'OTH'])->first();

            $check_property_id_in_new_record = PropertyMaster::where('old_propert_id', $request->property_id)->count();
            $check_property_id_in_child_property = SplitedPropertyDetail::where('old_property_id', $request->property_id)->count();
            // dd($check_property_id_in_new_record,$check_property_id_in_child_property);

            if ($check_property_id_in_new_record == 0 && $check_property_id_in_child_property == 0) {
                $colony = OldColony::colonyIdByColonyCode($jsonData[0]['ColonyCode']);
                $property_status = Item::getItemIdUsingItemCode($jsonData[0]['Status'], 109);
                $land_type = Item::getItemIdUsingItemCode($jsonData[0]['LandType'], 1051);
                $response = ['status' => true, 'message' => 'Property details fetched', 'data' => ['property_id' => $request->property_id, 'file_number' => $jsonData[0]['FileNumber'], 'property_status' => $property_status, 'colony_id' => $colony['0']->id, 'land_type' => $land_type]];
            } elseif ($check_property_id_in_child_property > 0){
                $splitedProperty = SplitedPropertyDetail::where('old_property_id', $request->property_id)->first();
                $parentProperty = PropertyMaster::find($splitedProperty->property_master_id);
                $response = ['status' => false, 'message' => 'Provided Property ID is a child property of '.$parentProperty->old_propert_id, 'data' => NULL];
            } elseif ($check_property_id_in_new_record > 0) {
                $response = ['status' => false, 'message' => 'Provided Property ID is already saved.', 'data' => NULL];
            } else {
                $response = ['status' => false, 'message' => 'Provided Property ID is wrong/dulicate marked.', 'data' => NULL];
            }

        }
        return json_encode($response);

    }
    
    //for searching PID of plots in multiple property form - Sourav Chauhan (9 Aug 2024)
    public function isPropertyAvailable(Request $request){
        $propertyId = $request->property_id;
        if (preg_match('/^\d{5}$/', $propertyId)) {
            $isPropertyExists = PropertyMaster::where('old_propert_id', $propertyId)->first();
            if($isPropertyExists){
                $data = [
                    'location' => 'parent',
                    'id' => $isPropertyExists['id']
                ];
                $response = ['status' => false, 'message' => 'PID already exist','data' => $data];
            } else {
                $isSplitedPropertyExists = SplitedPropertyDetail::where('old_property_id', $propertyId)->first();
                if($isSplitedPropertyExists){
                    $data = [
                        'location' => 'child',
                        'id' => $isSplitedPropertyExists['id']
                    ];
                    $response = ['status' => false, 'message' => 'PID already exist','data' => $data];
                } else {
                    $response = ['status' => true, 'message' => 'Id available'];
                }
            }
            
        } else {
            $response = ['status' => false, 'message' => 'PID already exist'];
        }
        return json_encode($response);

    }

     // Function for checking property id available while doing MIS throug It Cell - Lalit Tiwari - (22/jan/2025)
     public function searchPropThroughLocalityBlockPlot(Request $request)
     {
         if(!empty($request->locality) && !empty($request->block) && !empty($request->plot)){
             $recordExists = PropertyMaster::where([
                 ['new_colony_name', '=', $request->locality],
                 ['block_no', '=', $request->block],
                 ['plot_or_property_no', '=', $request->plot]
             ])->first();
             
             if ($recordExists) {
                $response = ['status' => true, 'message' => 'The property is available for the given locality, block, plot & Property Id is :- ' . $recordExists->old_propert_id . ''];
            } else {
                $response = ['status' => false, 'message' => ''];
            }
             return json_encode($response);
         }
     }
 
     // Function for Transfer Property To section By It Cell - Lalit (23/Jan/2025)
     public function transferPropertyToSection(Request $request){
         try {
             if(!empty($request->userId) && !empty($request->transferPropertyId))
             {
                 //Get Section Id From Property Section Mapping Table - Lalit Tiwari (23/Jan/2025)
                 $getPropertyDetails = PropertyMaster::where('old_propert_id', $request->transferPropertyId)->first();
                 if(empty($getPropertyDetails)){
                     return response()->json(['status' => 'failed', 'message' => 'Property Details not found for given property id']);
                 }
 
                 //Get Section Id From Property Section Mapping Table - Lalit Tiwari (23/Jan/2025)
                 $sectionId = PropertySectionMapping::where([
                     'colony_id' => $getPropertyDetails->new_colony_name,
                     'property_type' => $getPropertyDetails->property_type,
                     'property_subtype' => $getPropertyDetails->property_sub_type,
                 ])->value('section_id');
                 if(empty($sectionId)){
                     return response()->json(['status' => 'failed', 'message' => "Section Id is not Mapped with Property Mapping for Colony: " . $getPropertyDetails->new_colony_name.", Property type : ".$getPropertyDetails->property_type.", Property Sub type : ".$getPropertyDetails->property_sub_type]);
                 }
 
                 //Update Section Id In User Registration Table - Lalit Tiwari (23/Jan/2025)    
                 UserRegistration::where('id', $request->userId)->update(['locality' => $getPropertyDetails->new_colony_name,'section_id' => $sectionId]);
                 return response()->json(['status' => 'success', 'message' => 'Property successfully transfer to section']);
             } else {
                 return response()->json(['status' => 'failed', 'message' => 'Please provide User Id & Property Id For Transfer']);
             }
         } catch (\Exception $e) {
             return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
         }
         
     }
}
