<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Item;
use App\Models\PropertyMaster;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\PropertyInspectionDemandDetail;
use App\Models\PropertyMiscDetail;
use App\Models\PropertyContactDetail;
use App\Models\OldPropertId;
use App\Models\OldColony;
use App\Models\PropertyMasterHistory;
use App\Models\PropertyLeaseDetailHistory;
use App\Models\PropertyTransferLesseeDetailHistory;
use App\Models\PropInspDemandDetailHistory;
use App\Models\PropertyContactDetailsHistory;
use App\Models\PropertyMiscDetailHistory;
use App\Models\SplitedPropertyDetail;
use App\Models\SplitedPropertyDetailHistory;
use App\Models\CurrentLesseeDetail;
use App\Models\LndoLandRate;
use App\Models\CircleLandRate;
// use App\Models\FreeHoldDetail;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\CommonService;


class MisMultiplePropertyService
{

    //get all the active items of this group id
    public function getItemsByGroupId($id)
    {
        return Group::where('group_id', $id)->with([
            'items' => function ($query) {
                $query->where('is_active', 1)->orderBy('item_order');
            }
        ])->get();
    }


    //get the sub type for all purpose of type in lease details
    public function getRelatedSubTypes($request)
    {
        $propertytypeSubtpeMapping = DB::table('property_type_sub_type_mapping')->where('type', $request->property_type_id)->get();
        $subTypeIds = [];
        foreach ($propertytypeSubtpeMapping as $data) {
            $subTypeId = $data->sub_type;
            $subTypeIds[] = $subTypeId;
        }
        return $subTypes = Item::whereIn('id', $subTypeIds)->get();
    }


    //To save the mis multiple propety details
    //8/5/2024- Sourav Chauhan
    // public function storeMisMultipleData($request)
    // {
    //     //dd($request->all());
    //     try {
    //         $transactionSuccess = false;

    //         DB::transaction(function () use ($request, &$transactionSuccess) {
    //             // $old_property_data = OldPropertId::where('PropertyID', $request->property_id)->first();
    //             $response = Http::post('https://ldo.gov.in/eDhartiAPI/Api/GetValues/PropertyWiseStatus?EnteredPropertyID=' . $request->property_id);
    //             $jsonData = $response->json();
    //             $old_property_data = $jsonData[0]['PropertyID'];

    //             if ($old_property_data) {
    //                 $main_property_id = null;
    //                 // $main_property_id = $old_property_data['main_property_id'];
    //                 $section_code = $old_property_data['SectionCode'];
    //                 $property_id = $request->property_id;
    //             } else {
    //                 $main_property_id = null;
    //                 $colony_data = OldColony::find($request->present_colony_name);
    //                 $section_code = $colony_data['dealing_section_code'];
    //                 $property_id = self::getPropertyIdIfNotAvaiable();
    //             }

    //             $property_master_id = self::storePropetyBasicDetails($request, $property_id, $main_property_id, $section_code);
    //             $childs = self::storeLeaseDetails($request, $property_master_id, $property_id);

    //             $data = self::storeLandTransferDetails($request, $property_master_id, $property_id, $childs);

    //             self::storePropertyStatusDetails($request, $property_master_id, $property_id, $childs, $data);

    //             self::storeInspectionDemandDetails($request, $property_master_id, $property_id, $childs);
    //             self::storeMiscellaneousDetail($request, $property_master_id, $property_id, $childs);
    //             self::storeLatestContactDetail($request, $property_master_id, $property_id, $childs);

    //             $transactionSuccess = true;
    //         });

    //         if ($transactionSuccess) {
    //             return true;
    //         } else {
    //             Log::info("transaction failed");
    //             return false;
    //         }
    //     } catch (\Exception $e) {
    //         Log::info($e);
    //         return $e->getMessage();
    //     }
    // }
    public function storeMisMultipleData($request)
    {
        // dd($request->all());
        try {
            $transactionSuccess = false;

            DB::transaction(function () use ($request, &$transactionSuccess) {


                //Check is property already saved
                //Sourav Chauhan  - 28/May/2024
                $is_property_exist = PropertyMaster::where('old_propert_id', $request->property_id)->first();
                $is_property_exist_in_child = SplitedPropertyDetail::where('old_property_id', $request->property_id)->first();
                if (isset($is_property_exist) && isset($is_property_exist_in_child)) {
                    Log::info("Property Id already exist: " . $request->property_id);
                    return false;
                } else {
                    $main_property_id = null;
                    $colony_data = OldColony::find($request->present_colony_name);
                    $section_code = $colony_data['dealing_section_code'];
                    // $property_id = Self::getPropertyIdIfNotAvaiable();
                    $property_id = $request->property_id;

                    $property_master_id = self::storePropetyBasicDetails($request, $property_id, $main_property_id, $section_code);
                    $childs = self::storeLeaseDetails($request, $property_master_id, $property_id);

                    $data = self::storeLandTransferDetails($request, $property_master_id, $property_id, $childs);

                    self::storePropertyStatusDetails($request, $property_master_id, $property_id, $childs, $data);

                    self::storeInspectionDemandDetails($request, $property_master_id, $property_id, $childs);
                    self::storeMiscellaneousDetail($request, $property_master_id, $property_id, $childs);
                    self::storeLatestContactDetail($request, $property_master_id, $property_id, $childs);

                    $transactionSuccess = true;
                }

                // $old_property_data = OldPropertId::where('PropertyID', $request->property_id)->first();


                // if ($old_property_data) {
                //     $main_property_id = $old_property_data['main_property_id'];
                //     $section_code = $old_property_data['SectionCode'];
                //     $property_id = $request->property_id;
                // } else {
                //     $main_property_id = null;
                //     $colony_data = OldColony::find($request->present_colony_name);
                //     $section_code = $colony_data['dealing_section_code'];
                //     $property_id = Self::getPropertyIdIfNotAvaiable();
                // }


            });

            if ($transactionSuccess) {
                return true;
            } else {
                Log::info("transaction failed");
                return false;
            }
        } catch (\Exception $e) {
            Log::info("User ID: " . Auth::id() . " Error: " . $e);
            return $e->getMessage();
        }
    }



    //create a automated unique property ID
    public function getPropertyId()
    {
        $lastRecord = PropertyMaster::latest()->first();
        //dd($lastRecord);
        if ($lastRecord) {
            $lastId = (int) substr($lastRecord->unique_propert_id, 1);
            $nextId = 'L' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'L000001';
        }
        return $nextId;
    }

    public function getPropertyIdIfNotAvaiable()
    {
        $lastRecord = PropertyMaster::where('old_propert_id', 'LIKE', 'P%')->latest()->first();
        if ($lastRecord) {
            $lastId = (int) substr($lastRecord->old_propert_id, 1);
            $nextId = 'P' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'P00001';
        }
        return $nextId;
    }

    //create a automated file number
    public function getFileNumber($landType, $colonyCode, $block, $plotNo)
    {
        if (empty($landType)) {
            $landType = 'LT';
        } else {
            $item = new Item;
            $data = $item->itemNameById($landType);
            if ($data == 'Rehabilitation') {
                $landType = 'R';
            } else {
                $landType = 'N';
            }
        }
        if (empty($colonyCode)) {
            $colonyCode = 'Col';
        } else {
            $data = OldColony::where('id', $colonyCode)->first();
            $colonyCode = $data['code'];
        }

        if (empty($block)) {
            $block = '0';
        }
        if (empty($plotNo)) {
            $plotNo = 'P';
        }
        $fileNo = 'DL/' . $landType . '/' . $colonyCode . '/' . $block . '/' . $plotNo;
        return $fileNo;
    }


    //To save Property Basic details
    public function storePropetyBasicDetails($request, $property_id, $main_property_id, $section_code)
    {
        // dd($request);
        if (isset($request->is_multiple_prop_id)) {
            $is_multiple_prop_id = $request->is_multiple_prop_id;
        } else {
            $is_multiple_prop_id = null;
        }

        //for join property check
        if (isset($request->is_jointproperty)) {
            $is_joint_property = $request->is_jointproperty;
        } else {
            $is_joint_property = null;
        }

        if (isset($request->purpose_lease_type_alloted_present)) {
            $purpose_lease_type_alloted_presentValue = $request->purpose_lease_type_alloted_present;
            $purpose_lease_sub_type_alloted_presentValue = $request->purpose_lease_sub_type_alloted_present;
        } else {
            $purpose_lease_type_alloted_presentValue = $request->purpose_property_type;
            $purpose_lease_sub_type_alloted_presentValue = $request->purpose_property_sub_type;
        }

        $propertyMaster = PropertyMaster::create([
            'old_propert_id' => $property_id,
            'unique_propert_id' => self::getPropertyId(),
            'is_multiple_ids' => $is_multiple_prop_id,
            'is_joint_property' => $is_joint_property,
            'file_no' => $request->file_number,
            'unique_file_no' => self::getFileNumber($request->land_type, $request->present_colony_name, $request->block_no, $request->plot_no),
            'lease_no' => $request->lease_no,
            'plot_or_property_no' => $request->plot_no,
            'land_type' => $request->land_type,
            'old_colony_name' => $request->old_colony_name,
            'new_colony_name' => $request->present_colony_name,
            'block_no' => $request->block_no,
            'property_type' => $purpose_lease_type_alloted_presentValue,
            'property_sub_type' => $purpose_lease_sub_type_alloted_presentValue,
            'status' => $request->property_status,
            'main_property_id' => $main_property_id,
            'section_code' => $section_code,
            'is_transferred' => $request->transferred,
            'additional_remark' => $request->additional_remark,
            'alert_flag' => $request->alert_flag,
            'created_by' => Auth::id()
        ]);
        return $propertyMaster->id;
    }


    //To save Lease Details
    public function storeLeaseDetails($request, $property_master_id, $property_id)
    {

        //Self::createChildForParent($property_master_id);
        if ($request->ground_rent_unit == '1') {
            $gr_in_paisa = $request->ground_rent2;
            $gr_in_aana = null;
        } else {
            $gr_in_aana = $request->ground_rent2;
            $gr_in_paisa = null;
        }

        if ($request->premium_unit == '1') {
            $premium_in_paisa = $request->premium2;
            $premium_in_aana = null;
        } else {
            $premium_in_aana = $request->premium2;
            $premium_in_paisa = null;
        }
        $plot_area_in_sqm = self::convertToSquareMeter($request->area, $request->area_unit);
        // Commented on dated 20/dec/2024 - Lalit Tiwari
        // $plotValueData = self::calculatePlotValue($request, $plot_area_in_sqm, $request->present_colony_name);
        $plotValueData = CommonService::calculatePlotValue($request,$plot_area_in_sqm);
        //added by sourav for storing the land values - 5/juy/2024
        $propertyLeaseDetail = PropertyLeaseDetail::create([
            'property_master_id' => $property_master_id,
            'type_of_lease' => $request->lease_type,
            'lease_no' => $request->lease_no,
            'date_of_expiration' => $request->date_of_expiration,
            'doe' => $request->date_of_execution,
            'doa' => $request->date_of_allotment,
            'block_number' => $request->block_no,
            'plot_or_property_number' => $request->plot_no,
            'presently_known_as' => $request->presently_known,
            'plot_area' => $request->area,
            'unit' => $request->area_unit,
            'plot_area_in_sqm' => $plot_area_in_sqm,
            'plot_value' => $plotValueData['plot_value'], //added by sourav for storing the land values - 5/juy/2024
            'plot_value_cr' => $plotValueData['plot_value_cr'],
            'premium' => $request->premium1,
            'premium_in_paisa' => $premium_in_paisa,
            'premium_in_aana' => $premium_in_aana,
            'gr_in_re_rs' => $request->ground_rent1,
            'gr_in_paisa' => $gr_in_paisa,
            'gr_in_aana' => $gr_in_aana,
            'start_date_of_gr' => $request->start_date_of_gr,
            'rgr_duration' => $request->rgr_duration,
            'first_rgr_due_on' => $request->first_revision_of_gr_due,
            'property_type_as_per_lease' => $request->purpose_property_type,
            'property_sub_type_as_per_lease' => $request->purpose_property_sub_type,
            'is_land_use_changed' => $request->land_use_changed,
            'property_type_at_present' => $request->purpose_lease_type_alloted_present,
            'property_sub_type_at_present' => $request->purpose_lease_sub_type_alloted_present,
            'date_of_conveyance_deed' => $request->conveyanc_date[0],
            'in_possession_of_if_vacant' => $request->in_possession_of[0],
            'date_of_transfer' => $request->date_of_transfer[0],
            'remarks' => $request->remark[0],
            'created_by' => Auth::id()

        ]);


        if (isset($request->test)) {
            $favourOfs = $request->test;
            if ($favourOfs[0]['name'] != null) {
                foreach ($favourOfs as $favourOf) {
                    if ($favourOf['name'] != null) {
                        $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                            'property_master_id' => $property_master_id,
                            'old_property_id' => $property_id,
                            'process_of_transfer' => 'Original',
                            'transferDate' => $request->date_of_execution,//for saving date in case of original 24 april 2024
                            'lessee_name' => $favourOf['name'],
                            'batch_transfer_id' => 1,
                            'created_by' => Auth::id()
                        ]);
                    }
                }
            }
        }


        //for join property check
        //8/may/2024 Sourav Chauhan
        $childs = [];
        if (isset($request->is_jointproperty)) {
            $currentPropertyDetails = PropertyMaster::where('id', $property_master_id)->first();
            foreach ($request->jointProperty as $key => $property) {
                $propertyStatusFreehold = $request->freeHold;
                if ($request->property_status == '951') {//if default property is lease hold
                    if ($request->freeHold[$key + 1] == 'yes') {
                        $propertyStatus = 952;//splited property will be free hold
                    } else {
                        $propertyStatus = 951;//splited property will be lease hold
                    }
                } else if ($request->property_status == '952') {
                    $propertyStatus = 952;
                } else if ($propertyStatusFreehold[0] == 'yes') {//if default property is free hold
                    $propertyStatus = 952;
                } else {
                    $propertyStatus = null;//if property neither free hold nor lease hold
                }
                $plot_area_in_sqm_cild = self::convertToSquareMeter($property['jointpropertyarea'], $property['jointpropertyuit']);
                $plotValueData = self::calculatePlotValue($request, $plot_area_in_sqm_cild, $request->present_colony_name);//added by sourav for storing the land values - 5/juy/2024

                $splitedPropertyDetail = SplitedPropertyDetail::create([
                    'property_master_id' => $property_master_id,
                    'parent_prop_id' => $currentPropertyDetails->unique_propert_id,
                    'child_prop_id' => self::createChildForParent($currentPropertyDetails->unique_propert_id),
                    'plot_flat_no' => $property['jointplotno'],
                    'original_area' => $property['jointpropertyarea'],
                    'current_area' => $property['jointpropertyarea'],
                    'unit' => $property['jointpropertyuit'],
                    'area_in_sqm' => $plot_area_in_sqm_cild,
                    'plot_value' => $plotValueData['plot_value'], //added by sourav for storing the land values - 5/juy/2024
                    'plot_value_cr' => $plotValueData['plot_value_cr'],
                    'presently_known_as' => $property['jointpresently_knownas'],
                    'old_property_id' => $property['jointpropertyid'],
                    'property_status' => $propertyStatus,
                    'created_by' => Auth::id()
                ]);

                $childs[] = $splitedPropertyDetail->id;
            }
        }

        return $childs;
    }


    //to creating Child Id For the given Parent Id
    //8/May/2024 - Sourav Chauhan
    public function createChildForParent($parentID)
    {
        $availableRecords = SplitedPropertyDetail::where('parent_prop_id', $parentID)->get();
        if ($availableRecords->isNotEmpty()) {
            $lastId = $availableRecords->max('child_prop_id');
            $lastId = (int) substr($lastId, strpos($lastId, '/') + 1);
            $nextId = $parentID . '/' . ($lastId + 1);
        } else {
            $nextId = $parentID . '/1';
        }
        return $nextId;
    }


    public function calculatePlotValue($request, $plot_area_in_sqm, $colonyId)
    {
        // $colonyId = $request->present_colony_name;
        $lndoRate = LndoLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $circleRate = CircleLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $plot_value = 0;
        $plot_value_cr = 0;
        if ($lndoRate || $circleRate) {
            $lndoRateInv = null;
            $circleRateInv = null;

            $propertyType = $request->land_use_changed
                ? $request->purpose_lease_type_alloted_present
                : $request->purpose_property_type;
            switch ($propertyType) {
                case '47':
                    $lndoRateInv = $lndoRate ? $lndoRate['residential_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['residential_land_rate'] : null;
                    break;
                case '48':
                    $lndoRateInv = $lndoRate ? $lndoRate['commercial_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['commercial_land_rate'] : null;
                    break;
                case '49':
                    $lndoRateInv = $lndoRate ? $lndoRate['institutional_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['institutional_land_rate'] : null;
                    break;
            }
            $plotAreaInSqm = round($plot_area_in_sqm, 2);
            if ($lndoRateInv !== null) {
                $plot_value = round($lndoRateInv * $plotAreaInSqm, 2);
            }
            if ($circleRateInv !== null) {
                $plot_value_cr = round($circleRateInv * $plotAreaInSqm, 2);
            }
        } else {
            $plot_value = 0;
            $plot_value_cr = 0;
        }

        $data = [
            "plot_value" => $plot_value,
            "plot_value_cr" => $plot_value_cr
        ];

        return $data;

    }

    public function calculatePlotValueChild($request, $plot_area_in_sqm, $colonyId, $property_master_id)
    {
        // $colonyId = $request->present_colony_name;
        $lndoRate = LndoLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $circleRate = CircleLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $plot_value = 0;
        $plot_value_cr = 0;
        if ($lndoRate || $circleRate) {
            $lndoRateInv = null;
            $circleRateInv = null;

            $propertyType = PropertyMaster::where('id', $property_master_id)->first();
            switch ($propertyType['property_type']) {
                case '47':
                    $lndoRateInv = $lndoRate ? $lndoRate['residential_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['residential_land_rate'] : null;
                    break;
                case '48':
                    $lndoRateInv = $lndoRate ? $lndoRate['commercial_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['commercial_land_rate'] : null;
                    break;
                case '49':
                    $lndoRateInv = $lndoRate ? $lndoRate['institutional_land_rate'] : null;
                    $circleRateInv = $circleRate ? $circleRate['institutional_land_rate'] : null;
                    break;
            }
            $plotAreaInSqm = round($plot_area_in_sqm, 2);
            if ($lndoRateInv !== null) {
                $plot_value = round($lndoRateInv * $plotAreaInSqm, 2);
            }
            if ($circleRateInv !== null) {
                $plot_value_cr = round($circleRateInv * $plotAreaInSqm, 2);
            }
        } else {
            $plot_value = 0;
            $plot_value_cr = 0;
        }

        $data = [
            "plot_value" => $plot_value,
            "plot_value_cr" => $plot_value_cr
        ];

        return $data;

    }

    // To convert the area to square meter
    public function convertToSquareMeter($value, $fromUnit)
    {
        if ($fromUnit != 29) {
            $conversionFactors = [
                '27' => 4046.86,
                '28' => 0.092903,
                '30' => 0.836127,
                '589' => 10000,
            ];

            // Convert value to square meters
            if (array_key_exists($fromUnit, $conversionFactors)) {
                return $value * $conversionFactors[$fromUnit];
            } else {
                return null;
            }
        } else {
            return $value;
        }
    }



    //To save Land Transfer Details
    public function storeLandTransferDetails($request, $property_master_id, $property_id, $childs)
    {
        if (isset($request->land_transfer_type)) {
            foreach ($request->land_transfer_type as $key => $transfer) {

                $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
                // Batch transfer details
                if ($isPrevBatchId) {
                    $batch_transfer_id = $isPrevBatchId + 1;
                    $previous_batch_transfer_id = $isPrevBatchId;
                } else {
                    $batch_transfer_id = null;
                    $previous_batch_transfer_id = null;
                }

                // Assuming $request->name, $request->age, etc., are arrays, otherwise, adjust accordingly
                $names = $request->input('name' . ($key), []);
                $ages = $request->input('age' . ($key), []);
                $shares = $request->input('share' . ($key), []);
                $panNumbers = $request->input('panNumber' . ($key), []);
                $aadharNumbers = $request->input('aadharNumber' . ($key), []);

                // Assuming count of names is consistent with other arrays
                $count = count($names);

                for ($index = 0; $index < $count; $index++) {
                    if (isset($names[$index])) {
                        $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                            'property_master_id' => $property_master_id,
                            'old_property_id' => $property_id,
                            'process_of_transfer' => $transfer,
                            'transferDate' => $request->transferDate[$key], // Assuming $request->transferDate is defined and array
                            'lessee_name' => $names[$index],
                            'lessee_age' => $ages[$index],
                            'property_share' => $shares[$index],
                            'lessee_pan_no' => $panNumbers[$index],
                            'lessee_aadhar_no' => $aadharNumbers[$index],
                            'batch_transfer_id' => $batch_transfer_id,
                            'previous_batch_transfer_id' => $previous_batch_transfer_id,
                            'created_by' => Auth::id()
                        ]);
                    }

                }
            }
        } else {
            $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
        }

        //if plots data available
        //10/may/2024 - Sourav Chauhan
        // if(isset($request->outerList)){
        //     foreach($request->outerList as $key =>  $plots){
        //         $plotsCount = count($plots);
        //         for ($index = 0; $index < $plotsCount; $index++) {
        //             $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
        //             if ($isPrevBatchId) {
        //                 $batch_transfer_id = $isPrevBatchId + 1;
        //                 $previous_batch_transfer_id = $isPrevBatchId;
        //             } else {
        //                 $batch_transfer_id = null;
        //                 $previous_batch_transfer_id = null;
        //             }

        //             foreach($plots[$index]['innerList'] as $key => $lessee){
        //                 $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
        //                     'property_master_id' => $property_master_id,
        //                     'old_property_id' => $property_id,
        //                     'process_of_transfer' => $plots[$index]['land_transfer_type'],
        //                     'transferDate' => $plots[$index]['transferDate'], // Assuming $request->transferDate is defined and array
        //                     'lessee_name' => $lessee['name1'],
        //                     'lessee_age' => $lessee['age1'],
        //                     'property_share' => $lessee['share1'],
        //                     'lessee_pan_no' => $lessee['panNumber1'],
        //                     'lessee_aadhar_no' => $lessee['aadharNumber1'],


        //                     'batch_transfer_id' => $batch_transfer_id,
        //                     'previous_batch_transfer_id' => $previous_batch_transfer_id,
        //                     'created_by' => Auth::id()
        //                 ]);
        //             }
        //         }
        //     }

        // } 
        $isPrevBatchIdForPlot = null;
        // if($request->freeHold[0] != 'yes'){
        if (isset($request->outerList)) {
            foreach ($request->outerList as $index => $plots) {
                foreach ($plots as $key => $plot) {
                    $splited_property_detail_id = $childs[$index];
                    $landTransferType = $plot['land_transfer_type'] ?? null;
                    $transferDate = $plot['transferDate'] ?? null;
                    // Determine batch_transfer_id
                    $isPrevBatchIdForPlot = PropertyTransferredLesseeDetail::
                        where('property_master_id', $property_master_id)
                        ->where('splited_property_detail_id', $splited_property_detail_id)
                        ->max('batch_transfer_id');
                    if ($isPrevBatchIdForPlot) {
                        $batch_transfer_id = $isPrevBatchIdForPlot + 1;
                        $previous_batch_transfer_id = $isPrevBatchIdForPlot;
                    } else {
                        $batch_transfer_id = 1;
                        $previous_batch_transfer_id = null;
                    }
                    if (isset($plot['innerList'])) {
                        // Process each inner list
                        foreach ($plot['innerList'] as $lessee) {
                            if (isset($lessee['name1'])) {
                                PropertyTransferredLesseeDetail::create([
                                    'property_master_id' => $property_master_id,
                                    'splited_property_detail_id' => $splited_property_detail_id,
                                    'plot_flat_no' => $request->jointProperty[$index]['jointplotno'],
                                    'old_property_id' => $property_id,
                                    'process_of_transfer' => $landTransferType,
                                    'transferDate' => $transferDate, // Assuming $request->transferDate is defined and array
                                    'lessee_name' => $lessee['name1'],
                                    'lessee_age' => $lessee['age1'],
                                    'property_share' => $lessee['share1'],
                                    'lessee_pan_no' => $lessee['panNumber1'],
                                    'lessee_aadhar_no' => $lessee['aadharNumber1'],
                                    'batch_transfer_id' => $batch_transfer_id,
                                    'previous_batch_transfer_id' => $previous_batch_transfer_id,
                                    'created_by' => Auth::id()
                                ]);
                            }
                        }
                    }
                }
            }
        }
        // }

        $data = [$isPrevBatchId, $isPrevBatchIdForPlot];
        return $data;
    }


    //save prperty status details
    public function storePropertyStatusDetails($request, $property_master_id, $property_id, $childs, $data)
    {
        $childBatchIds = $data;
        if ($request->freeHold[0] == 'yes') {
            if (isset($request->stepFour)) {
                $favourOfs = $request->stepFour;
                if ($favourOfs[0]['name'] != null) {
                    foreach ($favourOfs as $favourOf) {
                        if ($favourOf['name'] != null) {
                            $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                                'property_master_id' => $property_master_id,
                                'old_property_id' => $property_id,
                                'process_of_transfer' => 'Conversion',
                                'transferDate' => $request->conveyanc_date[0], //save convence deed in case of conversion 24 april 2024
                                'lessee_name' => $favourOf['name'],
                                'batch_transfer_id' => $childBatchIds[0] + 2,
                                'previous_batch_transfer_id' => $childBatchIds[0] + 1,
                                'created_by' => Auth::id()
                            ]);
                        }
                    }
                }
            }
        } else {
            for ($i = 1; isset($request["stepFour$i"]); $i++) {
                $splited_property_detail_id = $childs[$i - 1];
                $maxBatchId = PropertyTransferredLesseeDetail::
                    where('property_master_id', $property_master_id)
                    ->where('splited_property_detail_id', $splited_property_detail_id)
                    ->max('batch_transfer_id');
                $data = $request["stepFour$i"];
                foreach ($data as $index => $item) {
                    if (!empty($item['name'])) {
                        PropertyTransferredLesseeDetail::create([
                            'property_master_id' => $property_master_id,
                            'splited_property_detail_id' => $splited_property_detail_id,
                            'plot_flat_no' => $request->jointProperty[$i - 1]['jointplotno'],
                            'old_property_id' => $property_id,
                            'process_of_transfer' => 'Conversion',
                            'transferDate' => $request->conveyanc_date[$i],
                            'lessee_name' => $item['name'],
                            'batch_transfer_id' => $maxBatchId + 1,
                            'previous_batch_transfer_id' => $maxBatchId,
                            'created_by' => Auth::id()
                        ]);
                    }
                }
            }
        }


        //current lessee details for splitted property
        //Sourav Chauhan - 01 July 2024
        if (isset($request->is_jointproperty)) {
            if (isset($request->jointProperty)) {
                $splitedProperties = SplitedPropertyDetail::whereIn('id', $childs)->get();
                foreach ($splitedProperties as $splitedProperty) {
                    $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->where('splited_property_detail_id', $splitedProperty->id)->max('batch_transfer_id');

                    if ($latestBatchId) {

                        $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)
                            ->where('splited_property_detail_id', $splitedProperty->id)
                            ->where('batch_transfer_id', $latestBatchId)
                            ->pluck('lessee_name')
                            ->toArray();

                        $lesseesNames = implode(", ", $lesseesWithLatestBatchId);
                        $lesseesNames = $lesseesNames ?? '';

                        $currentLesseeDetail = CurrentLesseeDetail::create([
                            'property_master_id' => $property_master_id,
                            'splited_property_detail_id' => $splitedProperty->id,
                            'old_property_id' => $splitedProperty->old_property_id,
                            'property_status' => $splitedProperty->property_status,
                            'lessees_name' => $lesseesNames,
                            'property_known_as' => $splitedProperty->presently_known_as,
                            'area' => $splitedProperty->original_area,
                            'unit' => $splitedProperty->unit,
                            'area_in_sqm' => $splitedProperty->area_in_sqm,
                            'created_by' => Auth::id()
                        ]);
                    }

                }

            }
        } else {
            //current lessee details
            //Sourav Chauhan - 20 June 2024
            $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
            $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)
                ->where('batch_transfer_id', $latestBatchId)
                ->pluck('lessee_name')
                ->toArray();

            $lesseesNames = implode(", ", $lesseesWithLatestBatchId);
            $lesseesNames = $lesseesNames ?? '';

            $currentLesseeDetail = CurrentLesseeDetail::create([
                'property_master_id' => $property_master_id,
                'splited_property_detail_id' => null,
                'old_property_id' => $property_id,
                'property_status' => $request->property_status,
                'lessees_name' => $lesseesNames,
                'property_known_as' => $request->presently_known,
                'area' => $request->area,
                'unit' => $request->area_unit,
                'area_in_sqm' => self::convertToSquareMeter($request->area, $request->area_unit),
                'created_by' => Auth::id()
            ]);

        }
        //End 
    }


    //To save Inspection and Demand Details
    public function storeInspectionDemandDetails($request, $property_master_id, $property_id, $childs)
    {
        //dd($request);
        $recordsCommingCount = $request->date_of_last_inspection_report;
        for ($i = 0; $i < count($recordsCommingCount); $i++) {
            if ($request->date_of_last_inspection_report[$i] != null || $request->date_of_last_demand_letter[$i] != null) {
                if ($i > 0) {
                    $splited_property_detail_id = $childs[$i - 1];
                } else {
                    $splited_property_detail_id = null;
                }
                $propertyInspectionDemandDetail = PropertyInspectionDemandDetail::create([
                    'property_master_id' => $property_master_id,
                    'splited_property_detail_id' => $splited_property_detail_id,
                    'old_property_id' => $property_id,
                    'last_inspection_ir_date' => $request->date_of_last_inspection_report[$i],
                    'last_demand_letter_date' => $request->date_of_last_demand_letter[$i],
                    'last_demand_id' => $request->demand_id[$i],
                    'last_demand_amount' => $request->amount_of_last_demand[$i],
                    'last_amount_received' => $request->last_amount_reveived[$i],
                    'last_amount_received_date' => $request->last_amount_date[$i],
                    'total_dues' => $request->amount_of_last_demand[$i] - $request->last_amount_reveived[$i],
                    'created_by' => Auth::id(),
                ]);
            }
        }
    }


    //To save Property Miscellaneous Details
    public function storeMiscellaneousDetail($request, $property_master_id, $property_id, $childs)
    {
        $recordsCommingCount = $request->GR;
        for ($i = 0; $i < count($recordsCommingCount); $i++) {
            if ($request->GR[$i] == '1' || $request->Supplementary[$i] == '1' || $request->Reentered[$i] == '1') {
                if ($i > 0) {
                    $splited_property_detail_id = $childs[$i - 1];
                } else {
                    $splited_property_detail_id = null;
                }

                //For storing the upplementary details -SOURAV CHAUHAN (16/july/2024)
                if ($request->supplementary_ground_rent_unit[$i] == '1') {
                    $gr_in_paisa = $request->supplementary_ground_rent2[$i];
                    $gr_in_aana = null;
                    $supplementary_total_gr = $request->supplementary_ground_rent1[$i] + ($gr_in_paisa / 100);
                } else {
                    $gr_in_aana = $request->supplementary_ground_rent2[$i];
                    $gr_in_paisa = null;
                    $supplementary_total_gr = $request->supplementary_ground_rent1[$i] + ($gr_in_aana / 16);
                }


                if ($request->supplementary_premium_unit[$i] == '1') {
                    $premium_in_paisa = $request->supplementary_premium2[$i];
                    $premium_in_aana = null;
                    $supplementary_total_premium = $request->supplementary_premium1[$i] + ($premium_in_paisa / 100);
                } else {
                    $premium_in_aana = $request->supplementary_premium2[$i];
                    $premium_in_paisa = null;
                    $supplementary_total_premium = $request->supplementary_premium1[$i] + ($premium_in_aana / 16);
                }

                $supplementary_area_in_sqm = self::convertToSquareMeter($request->supplementary_area[$i], $request->supplementary_area_unit[$i]);
                //For storing the upplementary details -SOURAV CHAUHAN (16/july/2024)


                $propertyMiscDetail = PropertyMiscDetail::create([
                    'property_master_id' => $property_master_id,
                    'splited_property_detail_id' => $splited_property_detail_id,
                    'old_property_id' => $property_id,
                    'is_gr_revised_ever' => $request->GR[$i],
                    'gr_revised_date' => $request->gr_revised_date[$i],
                    'is_supplimentry_lease_deed_executed' => $request->Supplementary[$i],
                    'supplimentry_lease_deed_executed_date' => $request->supplementary_date[$i],
                    'supplementary_area' => $request->supplementary_area[$i],//For storing the upplementary details -SOURAV CHAUHAN (8/july/2024)
                    'supplementary_area_unit' => $request->supplementary_area_unit[$i],
                    'supplementary_area_in_sqm' => $supplementary_area_in_sqm,
                    'supplementary_premium' => $request->supplementary_premium1[$i],
                    'supplementary_premium_in_paisa' => $premium_in_paisa,
                    'supplementary_premium_in_aana' => $premium_in_aana,
                    'supplementary_total_premium' => $supplementary_total_premium,
                    'supplementary_gr_in_re_rs' => $request->supplementary_ground_rent1[$i],
                    'supplementary_gr_in_paisa' => $gr_in_paisa,
                    'supplementary_gr_in_aana' => $gr_in_aana,
                    'supplementary_total_gr' => $supplementary_total_gr,
                    'supplementary_remark' => $request->supplementary_remark[$i],//For storing the upplementary details -SOURAV CHAUHAN (8/july/2024)
                    'is_re_rented' => $request->Reentered[$i],
                    're_rented_date' => $request->date_of_reentry[$i],
                    'created_by' => Auth::id(),
                ]);
            }
        }
    }


    //To save latest contact details Details
    public function storeLatestContactDetail($request, $property_master_id, $property_id, $childs)
    {

        $recordsCommingCount = $request->address;
        for ($i = 0; $i < count($recordsCommingCount); $i++) {
            if ($request->address[$i] != null) {
                if ($i > 0) {
                    $splited_property_detail_id = $childs[$i - 1];
                } else {
                    $splited_property_detail_id = null;
                }
                $propertyContactDetail = PropertyContactDetail::create([
                    'property_master_id' => $property_master_id,
                    'splited_property_detail_id' => $splited_property_detail_id,
                    'old_property_id' => $property_id,
                    'address' => $request->address[$i],
                    'phone_no' => $request->phone[$i],
                    'email' => $request->email[$i],
                    'as_on_date' => $request->date[$i],
                    'created_by' => Auth::id(),
                ]);
            }
        }

    }

    public function propertDetails()
    {
        $userId = Auth::id();
        $allowedUserIds = [27, 28, 29, 30, 31, 17, 41];

        if (in_array($userId, $allowedUserIds)) {
            $misData = PropertyMaster::latest()->get();
        } else {
            $misData = PropertyMaster::where('created_by', $userId)->latest()->get();
        }
        return $misData;

    }


    public function viewDetails($id)
    {
        $misData = PropertyMaster::where('id', $id)->first();
        //dd($misData->propertyTransferredLesseeDetails);
        return $misData;
    }


    //Update the property Details
    public function update($id, $request)
    {
        self::updatePropetyBasicDetails($id, $request);
        self::updateLeaseDetails($id, $request);
        self::updateLandTransferDetails($id, $request);
        self::updatePropertyStatusDetails($id, $request);
        self::updateInspectionDemandDetails($id, $request);
        self::updateMiscellaneousDetail($id, $request);
        self::updateContactDetails($id, $request);
        return true;
    }


    //Update Property Basic Details and save to property master model
    public function updatePropetyBasicDetails($id, $request)
    {
        $colony_data = OldColony::find($request->present_colony_name);
        $section_code = $colony_data['dealing_section_code'];
        if (isset($request->purpose_lease_type_alloted_present)) {
            $purpose_lease_type_alloted_presentValue = $request->purpose_lease_type_alloted_present;
            $purpose_lease_sub_type_alloted_presentValue = $request->purpose_lease_sub_type_alloted_present;
        } else {
            $purpose_lease_type_alloted_presentValue = $request->purpose_property_type;
            $purpose_lease_sub_type_alloted_presentValue = $request->purpose_property_sub_type;
        }
        $propertyMaster = PropertyMaster::find($id);
        $oldPropertyMaster = $propertyMaster->getOriginal();
        $propertyMaster->is_multiple_ids = $request->is_multiple_prop_id;
        $propertyMaster->file_no = $request->file_number;
        $propertyMaster->unique_file_no = self::getFileNumber($request->land_type, $request->present_colony_name, $request->block_no, $request->plot_no);
        $propertyMaster->lease_no = $request->lease_no;
        $propertyMaster->plot_or_property_no = $request->plot_no;
        $propertyMaster->land_type = $request->land_type;
        $propertyMaster->old_colony_name = $request->old_colony_name;
        $propertyMaster->new_colony_name = $request->present_colony_name;
        $propertyMaster->block_no = $request->block_no;
        $propertyMaster->property_type = $purpose_lease_type_alloted_presentValue;
        $propertyMaster->property_sub_type = $purpose_lease_sub_type_alloted_presentValue;
        $propertyMaster->status = $request->property_status;
        $propertyMaster->section_code = $section_code;
        $propertyMaster->is_transferred = $request->transferred;
        // $propertyMaster->save();
        if ($propertyMaster->isDirty()) {
            $propertyMaster->updated_by = Auth::id();
            $propertyMaster->save();
            $changes = $propertyMaster->getChanges();
            $propertyMasterHistory = new PropertyMasterHistory;
            $propertyMasterHistory->property_master_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $propertyMasterHistory->$key = $oldPropertyMaster[$key];
                    $newKey = 'new_' . $key;
                    $propertyMasterHistory->$newKey = $change;
                }
            }

            //dd($propertyMasterHistory);
            $propertyMasterHistory->updated_by = Auth::id();
            $propertyMasterHistory->save();
        }

    }



    //Update the property lease details
    public function updateLeaseDetails($id, $request)
    {

        // dd($request);

        // For updating the lease details
        if ($request->ground_rent_unit == '1') {
            $gr_in_paisa = $request->ground_rent2;
            $gr_in_aana = null;
        } else {
            $gr_in_aana = $request->ground_rent2;
            $gr_in_paisa = null;
        }

        if ($request->premium_unit == '1') {
            $premium_in_paisa = $request->premium2;
            $premium_in_aana = null;
        } else {
            $premium_in_aana = $request->premium2;
            $premium_in_paisa = null;
        }
        $plot_area_in_sqm = self::convertToSquareMeter($request->area, $request->area_unit);
        //Commented on dated 20/dec/2024 - Lalit Tiwari
        // $plotValueData = self::calculatePlotValue($request, $plot_area_in_sqm, $request->present_colony_name);
        $plotValueData = CommonService::calculatePlotValue($request,$plot_area_in_sqm);

        $propertyLeaseDetail = PropertyLeaseDetail::where('property_master_id', $id)->first();
        $oldPropertyLeaseDetail = $propertyLeaseDetail->getOriginal();
        $propertyLeaseDetail->type_of_lease = $request->lease_type;
        $propertyLeaseDetail->lease_no = $request->lease_no;
        $propertyLeaseDetail->date_of_expiration = $request->date_of_expiration;
        $propertyLeaseDetail->doa = $request->date_of_allotment;
        $propertyLeaseDetail->doe = $request->date_of_execution;
        $propertyLeaseDetail->block_number = $request->block_no;
        $propertyLeaseDetail->plot_or_property_number = $request->plot_no;
        $propertyLeaseDetail->presently_known_as = $request->presently_known;
        $propertyLeaseDetail->plot_area = $request->area;
        $propertyLeaseDetail->unit = $request->area_unit;
        $propertyLeaseDetail->plot_area_in_sqm = $plot_area_in_sqm;
        $propertyLeaseDetail->plot_value = $plotValueData['plot_value']; //added by sourav for udating the land values - 4/juy/2024
        $propertyLeaseDetail->plot_value_cr = $plotValueData['plot_value_cr'];
        $propertyLeaseDetail->premium = $request->premium1;
        $propertyLeaseDetail->premium_in_paisa = $premium_in_paisa;
        $propertyLeaseDetail->premium_in_aana = $premium_in_aana;
        $propertyLeaseDetail->gr_in_re_rs = $request->ground_rent1;
        $propertyLeaseDetail->gr_in_paisa = $gr_in_paisa;
        $propertyLeaseDetail->gr_in_aana = $gr_in_aana;
        $propertyLeaseDetail->start_date_of_gr = $request->start_date_of_gr;
        $propertyLeaseDetail->rgr_duration = $request->rgr_duration;
        $propertyLeaseDetail->first_rgr_due_on = $request->first_revision_of_gr_due;
        $propertyLeaseDetail->property_type_as_per_lease = $request->purpose_property_type;
        $propertyLeaseDetail->property_sub_type_as_per_lease = $request->purpose_property_sub_type;
        $propertyLeaseDetail->is_land_use_changed = $request->land_use_changed;
        $propertyLeaseDetail->property_type_at_present = $request->purpose_lease_type_alloted_present;
        $propertyLeaseDetail->property_sub_type_at_present = $request->purpose_lease_sub_type_alloted_present;
        $propertyLeaseDetail->date_of_conveyance_deed = $request->conveyanc_date;
        $propertyLeaseDetail->in_possession_of_if_vacant = $request->in_possession_of;
        $propertyLeaseDetail->date_of_transfer = $request->date_of_transfer;
        $propertyLeaseDetail->remarks = $request->remark;
        //dd($propertyLeaseDetail);

        if ($propertyLeaseDetail->isDirty()) {
            $propertyLeaseDetail->updated_by = Auth::id();
            $propertyLeaseDetail->save();
            $changes = $propertyLeaseDetail->getChanges();
            $propertyLeaseDetailHistory = new PropertyLeaseDetailHistory;
            $propertyLeaseDetailHistory->property_master_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $propertyLeaseDetailHistory->$key = $oldPropertyLeaseDetail[$key];
                    $newKey = 'new_' . $key;
                    $propertyLeaseDetailHistory->$newKey = $change;
                }
            }
            $propertyLeaseDetailHistory->updated_by = Auth::id();
            $propertyLeaseDetailHistory->save();
        }


        //For saving the lessee details to the PropertyTransferredLesseeDetail model
        $favourOfs = $request->original;
        if ($favourOfs) {
            foreach ($favourOfs as $index => $favourOf) {
                if ($favourOf != null) {
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('id', $index)->first();
                    $oldPropertyTransferLesseeDetailHistory = $propertyTransferredLesseeDetail->getOriginal();
                    $propertyTransferredLesseeDetail->transferDate = $request->date_of_execution;
                    $propertyTransferredLesseeDetail->lessee_name = $favourOf;
                    if ($propertyTransferredLesseeDetail->isDirty()) {
                        $propertyTransferredLesseeDetail->updated_by = Auth::id();
                        $propertyTransferredLesseeDetail->save();
                        $changes = $propertyTransferredLesseeDetail->getChanges();

                        $propertyTransferLesseeDetailHistory = new PropertyTransferLesseeDetailHistory;
                        $propertyTransferLesseeDetailHistory->property_master_id = $id;
                        foreach ($changes as $key => $change) {
                            if ($key != 'updated_at' && $key != 'updated_by') {
                                $propertyTransferLesseeDetailHistory->$key = $oldPropertyTransferLesseeDetailHistory[$key];
                                $newKey = 'new_' . $key;
                                $propertyTransferLesseeDetailHistory->$newKey = $change;
                                $propertyTransferLesseeDetailHistory->lessee_id = $index;
                            }
                        }
                        $propertyTransferLesseeDetailHistory->updated_by = Auth::id();
                        $propertyTransferLesseeDetailHistory->save();
                    }
                }
            }
        }

    }


    public function updateLandTransferDetails($id, $request)
    {
        if (isset($request->land_transfer_type)) {
            foreach ($request->land_transfer_type as $key => $transfer) {
                //dd($request->transferDate[$key]);
                // Assuming $request->name, $request->age, etc., are arrays, otherwise, adjust accordingly
                $ids = $request->input('id' . ($key + 1), []);
                $names = $request->input('name' . ($key + 1), []);
                $ages = $request->input('age' . ($key + 1), []);
                $shares = $request->input('share' . ($key + 1), []);
                $panNumbers = $request->input('panNumber' . ($key + 1), []);
                $aadharNumbers = $request->input('aadharNumber' . ($key + 1), []);

                // Assuming count of names is consistent with other arrays
                $count = count($names);

                for ($index = 0; $index < $count; $index++) {

                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('id', $ids[$index])->first();
                    $oldPropertyTransferLesseeDetailHistory = $propertyTransferredLesseeDetail->getOriginal();
                    $propertyTransferredLesseeDetail->process_of_transfer = $transfer;
                    $propertyTransferredLesseeDetail->transferDate = $request->transferDate[$key];
                    $propertyTransferredLesseeDetail->lessee_name = $names[$index];
                    $propertyTransferredLesseeDetail->lessee_age = $ages[$index];
                    $propertyTransferredLesseeDetail->property_share = $shares[$index];
                    $propertyTransferredLesseeDetail->lessee_pan_no = $panNumbers[$index];
                    $propertyTransferredLesseeDetail->lessee_aadhar_no = $aadharNumbers[$index];
                    if ($propertyTransferredLesseeDetail->isDirty()) {
                        $propertyTransferredLesseeDetail->updated_by = Auth::id();
                        $propertyTransferredLesseeDetail->save();
                        $changes = $propertyTransferredLesseeDetail->getChanges();
                        //dd($changes);

                        $propertyTransferLesseeDetailHistory = new PropertyTransferLesseeDetailHistory;
                        $propertyTransferLesseeDetailHistory->property_master_id = $id;
                        foreach ($changes as $key2 => $change) {
                            if ($key2 != 'updated_at' && $key2 != 'updated_by') {
                                $propertyTransferLesseeDetailHistory->$key2 = $oldPropertyTransferLesseeDetailHistory[$key2];
                                $newKey2 = 'new_' . $key2;
                                $propertyTransferLesseeDetailHistory->$newKey2 = $change;
                                $propertyTransferLesseeDetailHistory->lessee_id = $ids[$index];
                            }
                        }
                        $propertyTransferLesseeDetailHistory->updated_by = Auth::id();
                        $propertyTransferLesseeDetailHistory->save();
                    }
                }

            }
        }
    }

    //update the property status details
    public function updatePropertyStatusDetails($id, $request)
    {
        //dd($request->all());

        $favourOfs = $request->conversion;
        if ($favourOfs) {
            foreach ($favourOfs as $index => $favourOf) {
                if ($favourOf != null) {
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('id', $index)->first();
                    $oldPropertyTransferLesseeDetailHistory = $propertyTransferredLesseeDetail->getOriginal();
                    $propertyTransferredLesseeDetail->transferDate = $request->conveyanc_date;
                    $propertyTransferredLesseeDetail->lessee_name = $favourOf;
                    if ($propertyTransferredLesseeDetail->isDirty()) {
                        $propertyTransferredLesseeDetail->updated_by = Auth::id();
                        $propertyTransferredLesseeDetail->save();
                        $changes = $propertyTransferredLesseeDetail->getChanges();

                        $propertyTransferLesseeDetailHistory = new PropertyTransferLesseeDetailHistory;
                        $propertyTransferLesseeDetailHistory->property_master_id = $id;
                        foreach ($changes as $key => $change) {
                            if ($key != 'updated_at' && $key != 'updated_by') {
                                $propertyTransferLesseeDetailHistory->$key = $oldPropertyTransferLesseeDetailHistory[$key];
                                $newKey = 'new_' . $key;
                                $propertyTransferLesseeDetailHistory->$newKey = $change;
                                $propertyTransferLesseeDetailHistory->lessee_id = $index;
                            }
                        }
                        $propertyTransferLesseeDetailHistory->updated_by = Auth::id();
                        $propertyTransferLesseeDetailHistory->save();
                    }
                }
            }
        }


    }


    //update the inspection demand details
    public function updateInspectionDemandDetails($id, $request)
    {

        $propertyInsDemandDetails = PropertyInspectionDemandDetail::where('property_master_id', $id)->first();
        $oldPropertyInsDemandDetails = $propertyInsDemandDetails->getOriginal();

        $propertyInsDemandDetails->last_inspection_ir_date = $request->date_of_last_inspection_report;
        $propertyInsDemandDetails->last_demand_letter_date = $request->date_of_last_demand_letter;
        $propertyInsDemandDetails->last_demand_id = $request->demand_id;
        $propertyInsDemandDetails->last_demand_amount = $request->amount_of_last_demand;
        $propertyInsDemandDetails->last_amount_received = $request->last_amount_reveived;
        $propertyInsDemandDetails->last_amount_received_date = $request->last_amount_date;
        $propertyInsDemandDetails->total_dues = $request->amount_of_last_demand - $request->last_amount_reveived;
        if ($propertyInsDemandDetails->isDirty()) {
            $propertyInsDemandDetails->updated_by = Auth::id();
            $propertyInsDemandDetails->save();
            $changes = $propertyInsDemandDetails->getChanges();
            $propInspDemandDetailHistory = new PropInspDemandDetailHistory;
            $propInspDemandDetailHistory->property_master_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $propInspDemandDetailHistory->$key = $oldPropertyInsDemandDetails[$key];
                    $newKey = 'new_' . $key;
                    $propInspDemandDetailHistory->$newKey = $change;
                }
            }
            $propInspDemandDetailHistory->updated_by = Auth::id();
            $propInspDemandDetailHistory->save();
        }


    }


    //update the Miscellaneous details
    public function updateMiscellaneousDetail($id, $request)
    {
        $propertyMiscDetail = PropertyMiscDetail::where('property_master_id', $id)->first();
        $oldPropertyMiscDetail = $propertyMiscDetail->getOriginal();
        $propertyMiscDetail->is_gr_revised_ever = $request->GR;
        $propertyMiscDetail->gr_revised_date = $request->gr_revised_date;
        $propertyMiscDetail->is_supplimentry_lease_deed_executed = $request->Supplementary;
        $propertyMiscDetail->supplimentry_lease_deed_executed_date = $request->supplementary_date;
        $propertyMiscDetail->is_re_rented = $request->Reentered;
        $propertyMiscDetail->re_rented_date = $request->date_of_reentry;
        if ($propertyMiscDetail->isDirty()) {
            $propertyMiscDetail->updated_by = Auth::id();
            $propertyMiscDetail->save();
            $changes = $propertyMiscDetail->getChanges();
            $propertyMiscDetailHistory = new PropertyMiscDetailHistory;
            $propertyMiscDetailHistory->property_master_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $propertyMiscDetailHistory->$key = $oldPropertyMiscDetail[$key];
                    $newKey = 'new_' . $key;
                    $propertyMiscDetailHistory->$newKey = $change;
                }
            }
            $propertyMiscDetailHistory->updated_by = Auth::id();
            $propertyMiscDetailHistory->save();
        }
    }

    //update the contact details
    public function updateContactDetails($id, $request)
    {

        $propertyContactDetail = PropertyContactDetail::where('property_master_id', $id)->first();
        $oldPropertyContactDetail = $propertyContactDetail->getOriginal();
        $propertyContactDetail->address = $request->address;
        $propertyContactDetail->phone_no = $request->phone;
        $propertyContactDetail->email = $request->email;
        $propertyContactDetail->as_on_date = $request->date;
        if ($propertyContactDetail->isDirty()) {
            $propertyContactDetail->updated_by = Auth::id();
            $propertyContactDetail->save();
            $changes = $propertyContactDetail->getChanges();
            $propertyContactDetailsHistory = new PropertyContactDetailsHistory;
            $propertyContactDetailsHistory->property_master_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $propertyContactDetailsHistory->$key = $oldPropertyContactDetail[$key];
                    $newKey = 'new_' . $key;
                    $propertyContactDetailsHistory->$newKey = $change;
                }
            }
            $propertyContactDetailsHistory->updated_by = Auth::id();
            $propertyContactDetailsHistory->save();
        }
    }


    public function updateChild($id, $request)
    {
        $splitedPropertyDetail = SplitedPropertyDetail::find($id);
        $property_master_id = $splitedPropertyDetail->property_master_id;
        $old_property_id = $splitedPropertyDetail->old_property_id;

        self::updateChildBasicDetails($id, $request, $property_master_id, $old_property_id);
        self::updateChildLandTransferDetails($id, $request, $property_master_id, $old_property_id);
        self::updateChildPropertyStatusDetails($id, $request, $property_master_id, $old_property_id);
        self::updateChildInspectionDemandDetails($id, $request, $property_master_id, $old_property_id);
        self::updateChildMiscellaneousDetail($id, $request, $property_master_id, $old_property_id);
        self::updateChildContactDetails($id, $request, $property_master_id, $old_property_id);
        return true;

    }

    //update the Child Basic details
    public function updateChildBasicDetails($id, $request, $property_master_id, $old_property_id)
    {
        //added by sourav for udating the land values - 5/juy/2024
        $plot_area_in_sqm = self::convertToSquareMeter($request->area, $request->unit);
        $colonyId = PropertyMaster::where('id', $property_master_id)->pluck('new_colony_name')->toArray();
        //Commented on dated 20/dec/2024 - Lalit Tiwari
        // $plotValueData = self::calculatePlotValueChild($request, $plot_area_in_sqm, $colonyId[0], $property_master_id);
        $plotValueData = CommonService::calculatePlotValue($request, $plot_area_in_sqm);
        $splitedPropertyDetail = SplitedPropertyDetail::find($id);
        $oldSplitedPropertyDetail = $splitedPropertyDetail->getOriginal();
        $splitedPropertyDetail->plot_flat_no = $request->plot_no;
        $splitedPropertyDetail->original_area = $request->area;
        $splitedPropertyDetail->current_area = $request->area;
        $splitedPropertyDetail->unit = $request->unit;
        $splitedPropertyDetail->area_in_sqm = $plot_area_in_sqm;
        $splitedPropertyDetail->plot_value = $plotValueData['plot_value']; //added by sourav for udating the land values - 5/juy/2024
        $splitedPropertyDetail->plot_value_cr = $plotValueData['plot_value_cr'];
        $splitedPropertyDetail->presently_known_as = $request->presently_known_as;
        $splitedPropertyDetail->property_status = $request->property_status;

        // $propertyMaster->save();
        if ($splitedPropertyDetail->isDirty()) {
            $splitedPropertyDetail->updated_by = Auth::id();
            $splitedPropertyDetail->save();
            $changes = $splitedPropertyDetail->getChanges();
            $splitedPropertyDetailHistory = new SplitedPropertyDetailHistory;
            $splitedPropertyDetailHistory->splited_property_detail_id = $id;
            foreach ($changes as $key => $change) {
                if ($key != 'updated_at' && $key != 'updated_by') {
                    $splitedPropertyDetailHistory->$key = $oldSplitedPropertyDetail[$key];
                    $newKey = 'new_' . $key;
                    $splitedPropertyDetailHistory->$newKey = $change;
                }
            }

            $splitedPropertyDetailHistory->updated_by = Auth::id();
            $splitedPropertyDetailHistory->save();

        }
    }

    //update the Child Land Transfer details
    public function updateChildLandTransferDetails($id, $request, $property_master_id, $old_property_id)
    {

        if (isset($request->pre_land_transfer_type)) {
            foreach ($request->pre_land_transfer_type as $key => $transfer) {
                // Assuming $request->name, $request->age, etc., are arrays, otherwise, adjust accordingly
                $ids = $request->input('pre_id' . ($key + 1), []);
                $names = $request->input('pre_name' . ($key + 1), []);
                $ages = $request->input('pre_age' . ($key + 1), []);
                $shares = $request->input('pre_share' . ($key + 1), []);
                $panNumbers = $request->input('pre_panNumber' . ($key + 1), []);
                $aadharNumbers = $request->input('pre_aadharNumber' . ($key + 1), []);

                // Assuming count of names is consistent with other arrays
                $count = count($names);

                for ($index = 0; $index < $count; $index++) {

                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('id', $ids[$index])->first();
                    $oldPropertyTransferLesseeDetailHistory = $propertyTransferredLesseeDetail->getOriginal();
                    $propertyTransferredLesseeDetail->process_of_transfer = $transfer;
                    $propertyTransferredLesseeDetail->transferDate = $request->pre_transferDate[$key];
                    $propertyTransferredLesseeDetail->lessee_name = $names[$index];
                    $propertyTransferredLesseeDetail->lessee_age = $ages[$index];
                    $propertyTransferredLesseeDetail->property_share = $shares[$index];
                    $propertyTransferredLesseeDetail->lessee_pan_no = $panNumbers[$index];
                    $propertyTransferredLesseeDetail->lessee_aadhar_no = $aadharNumbers[$index];
                    if ($propertyTransferredLesseeDetail->isDirty()) {
                        $propertyTransferredLesseeDetail->updated_by = Auth::id();
                        $propertyTransferredLesseeDetail->save();
                        $changes = $propertyTransferredLesseeDetail->getChanges();
                        //dd($changes);

                        $propertyTransferLesseeDetailHistory = new PropertyTransferLesseeDetailHistory;
                        $propertyTransferLesseeDetailHistory->property_master_id = $property_master_id;
                        $propertyTransferLesseeDetailHistory->splited_property_detail_id = $id;
                        foreach ($changes as $key2 => $change) {
                            if ($key2 != 'updated_at' && $key2 != 'updated_by') {
                                $propertyTransferLesseeDetailHistory->$key2 = $oldPropertyTransferLesseeDetailHistory[$key2];
                                $newKey2 = 'new_' . $key2;
                                $propertyTransferLesseeDetailHistory->$newKey2 = $change;
                                $propertyTransferLesseeDetailHistory->lessee_id = $ids[$index];
                            }
                        }
                        $propertyTransferLesseeDetailHistory->updated_by = Auth::id();
                        $propertyTransferLesseeDetailHistory->save();
                    }
                }

            }
        }


        //if user add new transfer details
        if (isset($request->land_transfer_type)) {

            foreach ($request->land_transfer_type as $key => $transfer) {
                // Batch transfer details
                $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->where('splited_property_detail_id', $id)->max('batch_transfer_id');

                if ($isPrevBatchId) {
                    $batch_transfer_id = $isPrevBatchId + 1;
                    $previous_batch_transfer_id = $isPrevBatchId;
                } else {
                    $batch_transfer_id = null;
                    $previous_batch_transfer_id = null;
                }

                // Assuming $request->name, $request->age, etc., are arrays, otherwise, adjust accordingly
                $names = $request->input('name' . ($key + 1), []);
                $ages = $request->input('age' . ($key + 1), []);
                $shares = $request->input('share' . ($key + 1), []);
                $panNumbers = $request->input('panNumber' . ($key + 1), []);
                $aadharNumbers = $request->input('aadharNumber' . ($key + 1), []);

                // Assuming count of names is consistent with other arrays
                $count = count($names);

                for ($index = 0; $index < $count; $index++) {
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                        'property_master_id' => $property_master_id,
                        'splited_property_detail_id' => $id,
                        'plot_flat_no' => $request->plot_no,
                        'old_property_id' => $old_property_id,
                        'process_of_transfer' => $transfer,
                        'transferDate' => $request->transferDate[$key], // Assuming $request->transferDate is defined and array
                        'lessee_name' => $names[$index],
                        'lessee_age' => $ages[$index],
                        'property_share' => $shares[$index],
                        'lessee_pan_no' => $panNumbers[$index],
                        'lessee_aadhar_no' => $aadharNumbers[$index],
                        'batch_transfer_id' => $batch_transfer_id,
                        'previous_batch_transfer_id' => $previous_batch_transfer_id,
                        'created_by' => Auth::id()
                    ]);
                }
            }
        }

    }

    public function updateChildPropertyStatusDetails($id, $request, $property_master_id, $old_property_id)
    {
        if ($request->property_status == '952') {
            $favourOfs = $request->conversion;
            if ($favourOfs) {
                foreach ($favourOfs as $index => $favourOf) {
                    if ($favourOf != null) {
                        $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('id', $index)->first();
                        $oldPropertyTransferLesseeDetailHistory = $propertyTransferredLesseeDetail->getOriginal();
                        $propertyTransferredLesseeDetail->transferDate = $request->conveyanc_date;
                        $propertyTransferredLesseeDetail->lessee_name = $favourOf;
                        if ($propertyTransferredLesseeDetail->isDirty()) {
                            $propertyTransferredLesseeDetail->updated_by = Auth::id();
                            $propertyTransferredLesseeDetail->save();
                            $changes = $propertyTransferredLesseeDetail->getChanges();

                            $propertyTransferLesseeDetailHistory = new PropertyTransferLesseeDetailHistory;
                            $propertyTransferLesseeDetailHistory->property_master_id = $property_master_id;
                            $propertyTransferLesseeDetailHistory->splited_property_detail_id = $id;
                            foreach ($changes as $key => $change) {
                                if ($key != 'updated_at' && $key != 'updated_by') {
                                    $propertyTransferLesseeDetailHistory->$key = $oldPropertyTransferLesseeDetailHistory[$key];
                                    $newKey = 'new_' . $key;
                                    $propertyTransferLesseeDetailHistory->$newKey = $change;
                                    $propertyTransferLesseeDetailHistory->lessee_id = $index;
                                }
                            }
                            $propertyTransferLesseeDetailHistory->updated_by = Auth::id();
                            $propertyTransferLesseeDetailHistory->save();
                        }
                    }
                }
            }

            if (isset($request->stepFour)) {
                $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->where('splited_property_detail_id', $id)->max('batch_transfer_id');
                $favourOfs = $request->stepFour;
                if ($favourOfs[0]['name'] != null) {
                    foreach ($favourOfs as $favourOf) {
                        if ($favourOf != null) {
                            $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                                'property_master_id' => $property_master_id,
                                'splited_property_detail_id' => $id,
                                'plot_flat_no' => $request->plot_no,
                                'old_property_id' => $old_property_id,
                                'process_of_transfer' => 'Conversion',
                                'transferDate' => $request->conveyanc_date, //save convence deed in case of conversion 24 april 2024
                                'lessee_name' => $favourOf['name'],
                                'batch_transfer_id' => $isPrevBatchId + 1,
                                'previous_batch_transfer_id' => $isPrevBatchId,
                                'created_by' => Auth::id()
                            ]);
                        }
                    }
                }
            }
        }




        //update current lessee details
        //Sourav Chauhan - 18 july 2024
        $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->where('splited_property_detail_id', $id)->max('batch_transfer_id');
        $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('splited_property_detail_id', $id)
            ->where('property_master_id', $property_master_id)
            ->where('batch_transfer_id', $latestBatchId)
            ->pluck('lessee_name')
            ->toArray();
        $lesseesNames = implode(",", $lesseesWithLatestBatchId);
        $lesseesNames = $lesseesNames ?? '';
        $currentLesseeDetail = CurrentLesseeDetail::where('property_master_id', $property_master_id)->where('splited_property_detail_id', $id)->first();
        if (!empty($currentLesseeDetail)) {
            if ($currentLesseeDetail['lessees_name'] != $lesseesNames) {
                $currentLesseeDetail->property_status = $request->property_status;
                $currentLesseeDetail->lessees_name = $lesseesNames;
                $currentLesseeDetail->property_known_as = $request->presently_known_as;
                $currentLesseeDetail->area = $request->area;
                $currentLesseeDetail->unit = $request->unit;
                $currentLesseeDetail->area_in_sqm = self::convertToSquareMeter($request->area, $request->unit);
                $currentLesseeDetail->save();
            }
        } else {
            $currentLesseeDetail = CurrentLesseeDetail::create([
                'property_master_id' => $property_master_id,
                'splited_property_detail_id' => $id,
                'old_property_id' => $old_property_id,
                'property_status' => $request->property_status,
                'lessees_name' => $lesseesNames,
                'property_known_as' => $request->presently_known_as,
                'area' => $request->area,
                'unit' => $request->unit,
                'area_in_sqm' => self::convertToSquareMeter($request->area, $request->unit),
                'created_by' => Auth::id()
            ]);
        }




    }

    //update the Child Inspection and demand details
    public function updateChildInspectionDemandDetails($id, $request, $property_master_id, $old_property_id)
    {

        $splitedInsDemandDetails = PropertyInspectionDemandDetail::where('property_master_id', $property_master_id)
            ->where('splited_property_detail_id', $id)
            ->first();
        if (isset($splitedInsDemandDetails)) {
            $oldsplitedInsDemandDetails = $splitedInsDemandDetails->getOriginal();
            $splitedInsDemandDetails->last_inspection_ir_date = $request->date_of_last_inspection_report;
            $splitedInsDemandDetails->last_demand_letter_date = $request->date_of_last_demand_letter;
            $splitedInsDemandDetails->last_demand_id = $request->demand_id;
            $splitedInsDemandDetails->last_demand_amount = $request->amount_of_last_demand;
            $splitedInsDemandDetails->last_amount_received = $request->last_amount_reveived;
            $splitedInsDemandDetails->last_amount_received_date = $request->last_amount_date;
            $splitedInsDemandDetails->total_dues = $request->amount_of_last_demand - $request->last_amount_reveived;
            if ($splitedInsDemandDetails->isDirty()) {
                $splitedInsDemandDetails->updated_by = Auth::id();
                $splitedInsDemandDetails->save();
                $changes = $splitedInsDemandDetails->getChanges();
                $splitedInspDemandDetailHistory = new PropInspDemandDetailHistory;
                $splitedInspDemandDetailHistory->property_master_id = $property_master_id;
                $splitedInspDemandDetailHistory->splited_property_detail_id = $id;
                foreach ($changes as $key => $change) {
                    if ($key != 'updated_at' && $key != 'updated_by') {
                        $splitedInspDemandDetailHistory->$key = $oldsplitedInsDemandDetails[$key];
                        $newKey = 'new_' . $key;
                        $splitedInspDemandDetailHistory->$newKey = $change;
                    }
                }
                $splitedInspDemandDetailHistory->updated_by = Auth::id();
                $splitedInspDemandDetailHistory->save();
            }
        } else {
            if ($request->date_of_last_inspection_report || $request->date_of_last_demand_letter) {
                $PropertyInspectionDemandDetail = new PropertyInspectionDemandDetail;
                $PropertyInspectionDemandDetail->property_master_id = $property_master_id;
                $PropertyInspectionDemandDetail->splited_property_detail_id = $id;
                $PropertyInspectionDemandDetail->old_property_id = $old_property_id;
                $PropertyInspectionDemandDetail->last_inspection_ir_date = $request->date_of_last_inspection_report;
                $PropertyInspectionDemandDetail->last_demand_letter_date = $request->date_of_last_demand_letter;
                $PropertyInspectionDemandDetail->last_demand_id = $request->demand_id;
                $PropertyInspectionDemandDetail->last_demand_amount = $request->amount_of_last_demand;
                $PropertyInspectionDemandDetail->last_amount_received = $request->last_amount_reveived;
                $PropertyInspectionDemandDetail->last_amount_received_date = $request->last_amount_date;
                $PropertyInspectionDemandDetail->total_dues = $request->amount_of_last_demand - $request->last_amount_reveived;
                $PropertyInspectionDemandDetail->save();
            }
        }
    }

    //update the Child Miscellaneous details
    public function updateChildMiscellaneousDetail($id, $request, $property_master_id, $old_property_id)
    {
        //added for updating the supplementary details - SOURAV CHAUHAN (16/July/2024)
        if ($request->supplementary_ground_rent_unit == '1') {
            $gr_in_paisa = $request->supplementary_ground_rent2;
            $gr_in_aana = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_paisa / 100);
        } else {
            $gr_in_aana = $request->supplementary_ground_rent2;
            $gr_in_paisa = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_aana / 16);
        }


        if ($request->supplementary_premium_unit == '1') {
            $premium_in_paisa = $request->supplementary_premium2;
            $premium_in_aana = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_paisa / 100);
        } else {
            $premium_in_aana = $request->supplementary_premium2;
            $premium_in_paisa = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_aana / 16);
        }
        $supplementary_area_in_sqm = self::convertToSquareMeter($request->supplementary_area, $request->supplementary_area_unit);

        $splitedMisDetail = PropertyMiscDetail::where('property_master_id', $property_master_id)
            ->where('splited_property_detail_id', $id)
            ->first();
        if (isset($splitedMisDetail)) {
            $oldSplitedMiscDetail = $splitedMisDetail->getOriginal();
            $splitedMisDetail->is_gr_revised_ever = $request->GR;
            $splitedMisDetail->gr_revised_date = $request->gr_revised_date;
            $splitedMisDetail->is_supplimentry_lease_deed_executed = $request->Supplementary;
            $splitedMisDetail->supplimentry_lease_deed_executed_date = $request->supplementary_date;
            //added for updating the supplementary details - SOURAV CHAUHAN (16/July/2024)
            $splitedMisDetail->supplementary_area = $request->supplementary_area;
            $splitedMisDetail->supplementary_area_unit = $request->supplementary_area_unit;
            $splitedMisDetail->supplementary_area_in_sqm = $supplementary_area_in_sqm;
            $splitedMisDetail->supplementary_premium = $request->supplementary_premium1;
            $splitedMisDetail->supplementary_premium_in_paisa = $premium_in_paisa;
            $splitedMisDetail->supplementary_premium_in_aana = $premium_in_aana;
            $splitedMisDetail->supplementary_total_premium = $supplementary_total_premium;
            $splitedMisDetail->supplementary_gr_in_re_rs = $request->supplementary_ground_rent1;
            $splitedMisDetail->supplementary_gr_in_paisa = $gr_in_paisa;
            $splitedMisDetail->supplementary_gr_in_aana = $gr_in_aana;
            $splitedMisDetail->supplementary_total_gr = $supplementary_total_gr;
            $splitedMisDetail->supplementary_remark = $request->supplementary_remark;
            $splitedMisDetail->is_re_rented = $request->Reentered;
            $splitedMisDetail->re_rented_date = $request->date_of_reentry;
            if ($splitedMisDetail->isDirty()) {
                $splitedMisDetail->updated_by = Auth::id();
                $splitedMisDetail->save();
                $changes = $splitedMisDetail->getChanges();
                $propertyMiscDetailHistory = new PropertyMiscDetailHistory;
                $propertyMiscDetailHistory->property_master_id = $property_master_id;
                $propertyMiscDetailHistory->splited_property_detail_id = $id;
                foreach ($changes as $key => $change) {
                    if ($key != 'updated_at' && $key != 'updated_by') {
                        $propertyMiscDetailHistory->$key = $oldSplitedMiscDetail[$key];
                        $newKey = 'new_' . $key;
                        $propertyMiscDetailHistory->$newKey = $change;
                    }
                }
                $propertyMiscDetailHistory->updated_by = Auth::id();
                $propertyMiscDetailHistory->save();
            }
        } else {
            if ($request->gr_revised_date || $request->supplementary_date || $request->date_of_reentry) {
                $PropertyMiscDetail = new PropertyMiscDetail;
                $PropertyMiscDetail->property_master_id = $property_master_id;
                $PropertyMiscDetail->splited_property_detail_id = $id;
                $PropertyMiscDetail->old_property_id = $old_property_id;
                $PropertyMiscDetail->is_gr_revised_ever = $request->GR;
                $PropertyMiscDetail->gr_revised_date = $request->gr_revised_date;
                $PropertyMiscDetail->is_supplimentry_lease_deed_executed = $request->Supplementary;
                $PropertyMiscDetail->supplimentry_lease_deed_executed_date = $request->supplementary_date;
                //added for updating the supplementary details - SOURAV CHAUHAN (16/July/2024)
                $PropertyMiscDetail->supplementary_area = $request->supplementary_area;
                $PropertyMiscDetail->supplementary_area_unit = $request->supplementary_area_unit;
                $PropertyMiscDetail->supplementary_area_in_sqm = $supplementary_area_in_sqm;
                $PropertyMiscDetail->supplementary_premium = $request->supplementary_premium1;
                $PropertyMiscDetail->supplementary_premium_in_paisa = $premium_in_paisa;
                $PropertyMiscDetail->supplementary_premium_in_aana = $premium_in_aana;
                $PropertyMiscDetail->supplementary_total_premium = $supplementary_total_premium;
                $PropertyMiscDetail->supplementary_gr_in_re_rs = $request->supplementary_ground_rent1;
                $PropertyMiscDetail->supplementary_gr_in_paisa = $gr_in_paisa;
                $PropertyMiscDetail->supplementary_gr_in_aana = $gr_in_aana;
                $PropertyMiscDetail->supplementary_total_gr = $supplementary_total_gr;
                $PropertyMiscDetail->supplementary_remark = $request->supplementary_remark;
                $PropertyMiscDetail->is_re_rented = $request->Reentered;
                $PropertyMiscDetail->re_rented_date = $request->date_of_reentry;
                $PropertyMiscDetail->save();
            }

        }
    }


    //update the Child Contact details
    public function updateChildContactDetails($id, $request, $property_master_id, $old_property_id)
    {

        $splitedContactDetail = PropertyContactDetail::where('property_master_id', $property_master_id)
            ->where('splited_property_detail_id', $id)
            ->first();
        if (isset($splitedContactDetail)) {
            $oldSplitedContactDetail = $splitedContactDetail->getOriginal();
            $splitedContactDetail->address = $request->address;
            $splitedContactDetail->phone_no = $request->phone;
            $splitedContactDetail->email = $request->email;
            $splitedContactDetail->as_on_date = $request->date;
            if ($splitedContactDetail->isDirty()) {
                $splitedContactDetail->updated_by = Auth::id();
                $splitedContactDetail->save();
                $changes = $splitedContactDetail->getChanges();
                $splitedContactDetailsHistory = new PropertyContactDetailsHistory;
                $splitedContactDetailsHistory->property_master_id = $property_master_id;
                $splitedContactDetailsHistory->splited_property_detail_id = $id;
                foreach ($changes as $key => $change) {
                    if ($key != 'updated_at' && $key != 'updated_by') {
                        $splitedContactDetailsHistory->$key = $oldSplitedContactDetail[$key];
                        $newKey = 'new_' . $key;
                        $splitedContactDetailsHistory->$newKey = $change;
                    }
                }
                $splitedContactDetailsHistory->updated_by = Auth::id();
                $splitedContactDetailsHistory->save();
            }
        } else {

            $splitedContactDetail = new PropertyContactDetail;
            $splitedContactDetail->property_master_id = $property_master_id;
            $splitedContactDetail->splited_property_detail_id = $id;
            $splitedContactDetail->old_property_id = $old_property_id;
            $splitedContactDetail->address = $request->address;
            $splitedContactDetail->phone_no = $request->phone;
            $splitedContactDetail->email = $request->email;
            $splitedContactDetail->as_on_date = $request->date;
            $splitedContactDetail->save();

        }
    }


}