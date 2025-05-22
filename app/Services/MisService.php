<?php

namespace App\Services;

use App\Helpers\UserActionLogHelper;
use App\Models\ApplicationStatus;
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
use App\Models\CurrentLesseeDetail;
use App\Models\LndoLandRate;
use App\Models\CircleLandRate;
use App\Models\SectionMisHistory;
// use App\Models\FreeHoldDetail;
use App\Models\UnallottedPropertyDetail;
use App\Models\Department;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\CommonService;

use App\Models\NewlyAddedProperty;
use App\Models\PropertySectionMapping;
use App\Models\UserRegistration;

class MisService
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
        // $propertytypeSubtpeMapping = DB::table('property_type_sub_type_mapping')->where('type', $request->property_type_id)->get();
        $propertytypeSubtpeMapping = DB::table('property_type_sub_type_mapping')->where('type', $request->property_type_id)->where('is_active',1)->get();
        $subTypeIds = [];
        foreach ($propertytypeSubtpeMapping as $data) {
            $subTypeId = $data->sub_type;
            $subTypeIds[] = $subTypeId;
        }
        return $subTypes = Item::whereIn('id', $subTypeIds)->get();
    }
	
	//to save the unallotted data - SOURAV CHAUHAN (06/Dec/2024)
    public function storeUnallottedMisData($request)
    {
        try {
            // Start the transaction
            return DB::transaction(function () use ($request) {
                $transactionSuccess = false;
                
                // Check if the property exists in both tables
                $is_property_exist = PropertyMaster::where('old_propert_id', $request->property_id)->first();
                $is_property_exist_in_child = SplitedPropertyDetail::where('old_property_id', $request->property_id)->first();
            
                if ($is_property_exist && $is_property_exist_in_child) {
                    Log::info("Property Id already exists: " . $request->property_id);
                    throw new \Exception('Property already exists.');
                }
            
                $main_property_id = null;
                // $colony_data = OldColony::find($request->present_colony_name);
                // $section_code = $colony_data ? $colony_data['dealing_section_code'] : null;

                // Fetch the first matching section record from PropertySectionMapping based on colony_id, property_type, and property_subtype by SwatiMishra 13-03-2025 start
                $sectionMapping = PropertySectionMapping::where([
                    'colony_id' => $request->present_colony_name,
                    // 'property_type' => $request->purpose_property_type,
                    // 'property_subtype' => $request->purpose_property_sub_type,
                ])->first();

                // Check if sectionMapping exists, else log the issue and return false
                if (empty($sectionMapping) || empty($sectionMapping->section_id)) {
                    Log::info("Section Id is not Mapped with Property Mapping for Colony: " . 
                        $request->present_colony_name);
                    return false;
                }

                // Fetch section_code from Sections table using the first section_id found
                $section_code = Section::where('id', $sectionMapping->section_id)->value('section_code');
                //by SwatiMishra 13-03-2025 End

            
                $istransferred = 0;
                $isvacant = 0;
                $landparceltype = $request->landparceltype;
                if($landparceltype == 0){
                    $fileCode = 'V';
                    $isvacant = 1;
                } else {
                    if ($landparceltype && isset($request->department)) {
                        $department = Department::find($request->department);
                        if ($department) {
                            $fileCode = $department['file_code'];
                            $istransferred = 1;
                        }
                    }
                }
            
                // Create PropertyMaster record
                $propertyMaster = PropertyMaster::create([
                    'old_propert_id' => $request->property_id,
                    'unique_propert_id' => self::getProppertyId(),
                    'is_multiple_ids' => $request->is_multiple_prop_id ?: null,
                    'file_no' => $request->file_number,
                    'unique_file_no' => 'UA/'.$fileCode.'/'.self::getFileNumber($request->land_type, $request->present_colony_name, $request->vacantblockno, $request->plot_no),
                    'plot_or_property_no' => $request->plot_no,
                    'land_type' => $request->land_type,
                    'old_colony_name' => $request->old_colony_name,
                    'new_colony_name' => $request->present_colony_name,
                    'block_no' => $request->vacantblockno,
                    'status' => $request->property_status,
                    'main_property_id' => $main_property_id,
                    'section_code' => $section_code,
                    'is_transferred' => $istransferred,
                    'transferred_to' => $request->department,
                    'additional_remark' => $request->remarkUnallocated,
                    'created_by' => Auth::id(),
                ]);
            
                if ($propertyMaster) {
                    // Calculate plot area and plot value
                    $plot_area_in_sqm = self::convertToSquareMeter($request->area, $request->area_unit);
                    // Commented on dated 20/dec/2024 - Lalit Tiwari
                    // $plotValueData = self::calculateUnallotedPlotValue($request, $plot_area_in_sqm);
                    $plotValueData = CommonService::calculatePlotValue($request,$plot_area_in_sqm);
            
                    // Create UnallottedPropertyDetail record
                    $unallottedPropertyDetail = UnallottedPropertyDetail::create([
                        'property_master_id' => $propertyMaster->id,
                        'old_property_id' => $request->property_id,
                        'plot_area' => $request->area,
                        'unit' => $request->area_unit,
                        'plot_area_in_sqm' => $plot_area_in_sqm,
                        'plot_value' => $plotValueData['plot_value'],
                        'plot_value_cr' => $plotValueData['plot_value_cr'],
                        'is_litigation' => $request->islitigation,
                        'is_encrached' => $request->isencroachment,
                        'is_vaccant' => $isvacant,
                        'is_transferred' => $istransferred,
                        'transferred_to' => $request->department,
                        'is_property_document_exist' => $request->ispropertyDocumentExist,
                        'date_of_transfer' => $request->date_of_transfer,
                        'purpose' => $request->purpose,
                        'created_by' => Auth::id(),
                    ]);
            
                    if ($unallottedPropertyDetail) {
                        $transactionSuccess = true;
                    } else {
                        $transactionSuccess = false;
                        throw new \Exception('Failed to create Unallotted Property Detail.');
                    }
                } else {
                    $transactionSuccess = false;
                    throw new \Exception('Failed to create PropertyMaster.');
                }
            
                // Return success status after the transaction block ends
                if ($transactionSuccess) {
                    Log::info("Transaction completed successfully for Property ID: " . $request->property_id);
                    return true;
                }

                // Default case if transaction is not successful
                return false;
            });
        } catch (\Exception $e) {
            Log::error("Transaction failed: " . $e->getMessage());
            return $e->getMessage();
        }
    }
    //to save the full mis form details
    public function storeMisData($request)
    {
        try {
            $transactionSuccess = false;
            DB::transaction(function () use ($request, &$transactionSuccess) {
                $is_property_exist = PropertyMaster::where('old_propert_id', $request->property_id)->first();
                $is_property_exist_in_child = SplitedPropertyDetail::where('old_property_id', $request->property_id)->first();
                if (isset($is_property_exist) && isset($is_property_exist_in_child)) {
                    Log::info("Property Id already exist: " . $request->property_id);
                    return false;
                } else {
                    //Start :- Check If property already exist for same locality,block & plot for PropertyMaster & SplitedPropertyDetail
                    //have to uncomment when MIS Done
                    // $isPropertyExist = PropertyMaster::where([
                    //     ['new_colony_name', '=', $request->present_colony_name],
                    //     ['block_no', '=', $request->block_no],
                    //     ['plot_or_property_no', '=', $request->plot_no]
                    // ])->first();
                    // if(!empty($isPropertyExist)){
                    //     Log::info("Property already exist with locality :- " . $request->present_colony_name.", Block :- ".$request->block_no." & Plot :- ". $request->plot_no);
                    //     return false;
                    // }
                    //End :- Check If property already exist for same locality,block & plot for PropertyMaster & SplitedPropertyDetail

                    $main_property_id = null;
                    // $colony_data = OldColony::find($request->present_colony_name);
                    // $section_code = $colony_data['dealing_section_code'];

                    // Fetch the first matching section record from PropertySectionMapping based on colony_id, property_type, and property_subtype by SwatiMishra 13-03-2025 start
                    $sectionMapping = PropertySectionMapping::where([
                        'colony_id' => $request->present_colony_name,
                        'property_type' => $request->purpose_property_type,
                        'property_subtype' => $request->purpose_property_sub_type,
                    ])->first();

                    // Check if sectionMapping exists, else log the issue and return false
                    if (empty($sectionMapping)) {
                        Log::info("Section Id is not Mapped with Property Mapping for Colony: " . 
                            $request->present_colony_name . ", Property type: " . 
                            $request->purpose_property_type . ", Property Sub type: " . 
                            $request->purpose_property_sub_type);
                        return false;
                    }

                    // Fetch section_code from Sections table using the first section_id found
                    //$section_code = Section::where('id', $sectionMapping->section_id)->value('section_code');
                    $section_code = $sectionMapping->section->section_code;
                    //by SwatiMishra 13-03-2025 End
                    // $property_id = Self::getPropertyIdIfNotAvaiable();
                    // Added code to check property id is not posted through search then create manually for manual registration mis - Lalit Tiwari (16/Jan/2015)
                    if(empty($request->property_id)){
                        $property_id = Self::getPropertyIdIfNotAvaiable();
                    } else {
                        $property_id = $request->property_id;
                    }
                    $property_master_id = self::storePropetyBasicDetails($request, $property_id, $main_property_id, $section_code);
                    self::storeLeaseDetails($request, $property_master_id, $property_id);
                    $isPrevBatchId = self::storeLandTransferDetails($request, $property_master_id, $property_id);
                    self::storePropertyStatusDetails($request, $property_master_id, $property_id, $isPrevBatchId);
                    self::storeInspectionDemandDetails($request, $property_master_id, $property_id);
                    self::storeMiscellaneousDetail($request, $property_master_id, $property_id);
                    self::storeLatestContactDetail($request, $property_master_id, $property_id);

                     // Update Locality,generated_pid and section_id in User registration table - Lalit Tiwari (16/jan/2025) 
                     if(!empty($request->regUserId)){
                        self::updateUserRegistrationTable($request,$property_id);
                    }
                    // Update Locality,generated_pid and section_id in New Added Property table - Lalit Tiwari (21/jan/2025) 
                    if(!empty($request->newPropUserId)){
                        self::updateNewAddedPropertyTable($request,$property_id);
                    }

                    // Helper function to Manage User Activity / Action Logs for MIS
                    $property_id_link = '<a href="' . url("/property-details/{$property_master_id}/view") . '" target="_blank">' . $request->property_id . '</a>';
                    UserActionLogHelper::UserActionLog('create', url("/property-details/$property_master_id/view"), 'propertyProfarma', "New property ".$property_id_link." has been created.");
                    $transactionSuccess = true;
                }
            });
            if ($transactionSuccess) {
                return true;
            } else {
                Log::info("transaction failed");
                return false;
            }
        } catch (\Exception $e) {
            Log::info($e);
            return $e->getMessage();
        }
    }
    //create a automated unique property ID
    public function getProppertyId()
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
    public function getProppertyIdIfNotAvaiable()
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
        if (isset($request->is_multiple_prop_id)) {
            $is_multiple_prop_id = $request->is_multiple_prop_id;
        } else {
            $is_multiple_prop_id = false;
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
            'unique_propert_id' => self::getProppertyId(),
            'is_multiple_ids' => $is_multiple_prop_id,
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
        // $plotValueData = self::calculatePlotValue($request, $plot_area_in_sqm);
        $plotValueData = CommonService::calculatePlotValue($request,$plot_area_in_sqm);
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
            'plot_value' => $plotValueData['plot_value'], //added by sourav for storing the land values - 4/juy/2024
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
            'date_of_land_change' => $request->date_of_land_change,
            'property_type_at_present' => $request->purpose_lease_type_alloted_present,
            'property_sub_type_at_present' => $request->purpose_lease_sub_type_alloted_present,
            'date_of_conveyance_deed' => $request->conveyanc_date,
            'in_possession_of_if_vacant' => $request->in_possession_of,
            'date_of_transfer' => $request->date_of_transfer,
            'remarks' => $request->remark,
            'created_by' => Auth::id()
        ]);
        $favourOfs = $request->test;
        if ($favourOfs[0]['name'] != null) {
            foreach ($favourOfs as $favourOf) {
                if ($favourOf['name'] != null) {
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                        'property_master_id' => $property_master_id,
                        'old_property_id' => $property_id,
                        'process_of_transfer' => 'Original',
                        'transferDate' => $request->date_of_execution, //for saving date in case of original 24 april 2024
                        'lessee_name' => $favourOf['name'],
                        'batch_transfer_id' => 1,
                        'created_by' => Auth::id()
                    ]);
                }
            }
        }
    }
    public function calculatePlotValue($request, $plot_area_in_sqm)
    {
        $colonyId = $request->present_colony_name;
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

    public function calculateUnallotedPlotValue($request, $plot_area_in_sqm){
        $colonyId = $request->present_colony_name;
        $lndoRate = LndoLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();
        $circleRate = CircleLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();
        $plot_value = 0;
        $plot_value_cr = 0;
        if ($lndoRate || $circleRate) {
            $lndoRateInv = $lndoRate ? $lndoRate['residential_land_rate'] : null;
            $circleRateInv = $circleRate ? $circleRate['residential_land_rate'] : null;
        }
        $plotAreaInSqm = round($plot_area_in_sqm, 2);
        if ($lndoRateInv !== null) {
            $plot_value = round($lndoRateInv * $plotAreaInSqm, 2);
        }
        if ($circleRateInv !== null) {
            $plot_value_cr = round($circleRateInv * $plotAreaInSqm, 2);
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
    public function storeLandTransferDetails($request, $property_master_id, $property_id)
    {
        if (isset($request->land_transfer_type[0])) {
            foreach ($request->land_transfer_type as $key => $transfer) {

                if($transfer != null){
                    // Batch transfer details
                    $isPrevBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
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
        return $isPrevBatchId;
    }
    //save prperty status details
    public function storePropertyStatusDetails($request, $property_master_id, $property_id, $isPrevBatchId)
    {
        if($request->property_status == '952' && $request->freeHold == 'Yes'){
            $favourOfs = $request->stepFour;
            if ($favourOfs[0]['name'] != null) {
                foreach ($favourOfs as $favourOf) {
                    if ($favourOf['name'] != null) {
                        $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::create([
                            'property_master_id' => $property_master_id,
                            'old_property_id' => $property_id,
                            'process_of_transfer' => 'Conversion',
                            'transferDate' => $request->conveyanc_date, //save convence deed in case of conversion 24 april 2024
                            'lessee_name' => $favourOf['name'],
                            'batch_transfer_id' => $isPrevBatchId + 2,
                            'previous_batch_transfer_id' => $isPrevBatchId + 1,
                            'created_by' => Auth::id()
                        ]);
                    }
                }
                // $freeHoldDetail = FreeHoldDetail::create([
                //     'property_master_id' => $property_master_id,
                //     'old_property_id' => $property_id,
                //     'name' => $favourOf['name'],
                //     'known_as_present' => $favourOf['pkap'],
                //     'area' => $favourOf['area'],
                //     'created_by' => Auth::id()
                // ]);
            }
        } 
        // dd('outside if');
        //current lessee details
        //Sourav Chauhan - 19 June 2024
        $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)->max('batch_transfer_id');
        $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property_master_id)
            ->where('batch_transfer_id', $latestBatchId)
            ->pluck('lessee_name')
            ->toArray();
        $lesseesNames = implode(",", $lesseesWithLatestBatchId);
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
    //To save Inspection and Demand Details
    public function storeInspectionDemandDetails($request, $property_master_id, $property_id)
    {
        $propertyInspectionDemandDetail = PropertyInspectionDemandDetail::create([
            'property_master_id' => $property_master_id,
            'old_property_id' => $property_id,
            'last_inspection_ir_date' => $request->date_of_last_inspection_report,
            'last_demand_letter_date' => $request->date_of_last_demand_letter,
            'last_demand_id' => $request->demand_id,
            'last_demand_amount' => $request->amount_of_last_demand,
            'last_amount_received' => $request->last_amount_reveived,
            'last_amount_received_date' => $request->last_amount_date,
            'total_dues' => $request->amount_of_last_demand - $request->last_amount_reveived,
            'created_by' => Auth::id(),
        ]);
    }
    //To save Property Miscellaneous Details
    public function storeMiscellaneousDetail($request, $property_master_id, $property_id)
    {

        // dd($request->all(), $property_master_id, $property_id);

        if($request->supplementary_ground_rent_unit == '1'){
            $gr_in_paisa = $request->supplementary_ground_rent2;
            $gr_in_aana = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_paisa / 100);
        } else{
            $gr_in_aana = $request->supplementary_ground_rent2;
            $gr_in_paisa = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_aana / 16);
        }

        
        if($request->supplementary_premium_unit == '1'){
            $premium_in_paisa = $request->supplementary_premium2;
            $premium_in_aana = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_paisa / 100);
        } else{
            $premium_in_aana = $request->supplementary_premium2;
            $premium_in_paisa = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_aana / 16);
        }
        $supplementary_area_in_sqm = Self::convertToSquareMeter($request->supplementary_area, $request->supplementary_area_unit);
        // dd($request);
        $propertyMiscDetail = PropertyMiscDetail::create([
            'property_master_id' => $property_master_id,
            'old_property_id' => $property_id,
            'is_gr_revised_ever' => $request->GR,
            'gr_revised_date' => $request->gr_revised_date,
            'is_supplimentry_lease_deed_executed' => $request->Supplementary,
            'supplimentry_lease_deed_executed_date' => $request->supplementary_date,
            'supplementary_area' => $request->supplementary_area,
            'supplementary_area_unit' => $request->supplementary_area_unit,
            'supplementary_area_in_sqm' => $supplementary_area_in_sqm,
            'supplementary_premium' => $request->supplementary_premium1,
            'supplementary_premium_in_paisa' => $premium_in_paisa,
            'supplementary_premium_in_aana' => $premium_in_aana,
            'supplementary_total_premium' => $supplementary_total_premium,
            'supplementary_gr_in_re_rs' => $request->supplementary_ground_rent1,
            'supplementary_gr_in_paisa' => $gr_in_paisa,
            'supplementary_gr_in_aana' => $gr_in_aana,
            'supplementary_total_gr' => $supplementary_total_gr,
            'supplementary_remark' => $request->supplementary_remark,
            'is_re_rented' => $request->Reentered,
            're_rented_date' => $request->date_of_reentry,
            'created_by' => Auth::id(),
        ]);

        // dd($propertyMiscDetail);
    }
    //To save latest contact details Details
    public function storeLatestContactDetail($request, $property_master_id, $property_id)
    {
        $propertyContactDetail = PropertyContactDetail::create([
            'property_master_id' => $property_master_id,
            'old_property_id' => $property_id,
            'address' => $request->address,
            'phone_no' => $request->phone,
            'email' => $request->email,
            'as_on_date' => $request->date,
            'created_by' => Auth::id(),
        ]);
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
    public function propertyChildDetails($id)
    {
        $childData = SplitedPropertyDetail::where('id', $id)->first();
        $ParentData = self::viewDetails($childData['property_master_id']);
        $data = [
            'childData' => $childData,
            'ParentData' => $ParentData
        ];
        return $data;
    }
    //Update the property Details
    public function update($id, $request)
    {
        $propertyDetails = PropertyMaster::find($id);
        $old_property_id = $propertyDetails->old_propert_id;
        self::updatePropetyBasicDetails($id, $request);
        self::updateLeaseDetails($id, $request);
        self::updateLandTransferDetails($id, $request);
        self::updatePropertyStatusDetails($id, $request, $old_property_id);
        self::updateInspectionDemandDetails($id, $request, $old_property_id);
        self::updateMiscellaneousDetail($id, $request, $old_property_id);
        self::updateContactDetails($id, $request);
        // By Lalit on 17/09/2024 :- If Auth user role has section-officer then while update mis insert record into applicaiton status & section mis histories table
        if(Auth::user()->hasAnyRole('section-officer')){
            self::insertRecordAppStatusAndSectionMisHis($id, $request, $old_property_id);
        }
        // Helper function to Manage User Activity / Action Logs for MIS
        $property_id_link = '<a href="' . url("/property-details/{$id}/view") . '" target="_blank">' . $id . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/property-details/$id/view"), 'propertyProfarma', "Property ".$property_id_link." has been updated.");
        return true;
    }
    //Delete Lease details through id. Remember delete is soft delete not parmanent delete.
    public function delete($id, $request)
    {
        $PropertyTransferredLesseeDetails = PropertyTransferredLesseeDetail::find($id);
        if (!empty($PropertyTransferredLesseeDetails)) {
            $propertyLeaseDetailHistory = new PropertyTransferLesseeDetailHistory();
            $propertyLeaseDetailHistory->property_master_id = $PropertyTransferredLesseeDetails->property_master_id;
            $propertyLeaseDetailHistory->lessee_id = $PropertyTransferredLesseeDetails->id;
            $propertyLeaseDetailHistory->is_active = 1;
            $propertyLeaseDetailHistory->new_is_active = 0;
            $propertyLeaseDetailHistory->updated_by  = Auth::id();
            if ($propertyLeaseDetailHistory->save()) {
                $PropertyTransferredLesseeDetails->is_active = 0;
                if ($PropertyTransferredLesseeDetails->delete()) {
                    return true;
                }
            }
        }
    }
    //Delete Land transfer details through batch id. Remember delete is soft delete not parmanent delete.
    public function deleteLandTransferByBatchId($batchTransferId, $propertyMasterId, $request)
    {
        $PropertyTransferredLesseeDetails = PropertyTransferredLesseeDetail::where('batch_transfer_id', $batchTransferId)
            ->where('property_master_id', $propertyMasterId)
            ->get();
        if ($PropertyTransferredLesseeDetails->isNotEmpty()) {
            foreach ($PropertyTransferredLesseeDetails as $PropertyTransferredLesseeDetail) {
                $propertyLeaseDetailHistory = new PropertyTransferLesseeDetailHistory();
                $propertyLeaseDetailHistory->property_master_id = $PropertyTransferredLesseeDetail->property_master_id;
                $propertyLeaseDetailHistory->lessee_id = $PropertyTransferredLesseeDetail->id;
                $propertyLeaseDetailHistory->is_active = 1;
                $propertyLeaseDetailHistory->new_is_active = 0;
                $propertyLeaseDetailHistory->updated_by = Auth::id();
                if ($propertyLeaseDetailHistory->save()) {
                    $PropertyTransferredLesseeDetail->is_active = 0;
                    $PropertyTransferredLesseeDetail->delete();
                }
            }
            return true;
        }
    }
    public function checkMoreRecordExistForBatchId($batchTransferId, $propertyMasterId, $request)
    {
        $isExists = PropertyTransferredLesseeDetail::where('batch_transfer_id', $batchTransferId)->where('property_master_id', $propertyMasterId)->exists();
        if (!empty($isExists)) {
            return true;
        } else {
            return false;
        }
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
        $propertyMaster->additional_remark = $request->additional_remark;
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
        // $plotValueData = self::calculatePlotValue($request, $plot_area_in_sqm);
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
        //$propertyLeaseDetail->plot_value = '';  //Commented by Amita so that updated plot_value doesn't get change from blank string [02-07-2024]
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
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::withTrashed()->where('id', $index)->first();
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
        //For newly added in favour lease details to the PropertyTransferredLesseeDetail model
        $newFavourOfs = $request->in_favor_new;
        if ($newFavourOfs) {
            foreach ($newFavourOfs as $index => $newFavourOf) {
                $propertyTransferredLesseeDetail = new PropertyTransferredLesseeDetail();
                $propertyTransferredLesseeDetail->property_master_id = $id;
                $propertyTransferredLesseeDetail->old_property_id = $request->property_id;
                $propertyTransferredLesseeDetail->process_of_transfer = 'Original';
                $propertyTransferredLesseeDetail->transferDate = $request->date_of_execution;
                $propertyTransferredLesseeDetail->lessee_name = $newFavourOf;
                $propertyTransferredLesseeDetail->batch_transfer_id = 1;
                $propertyTransferredLesseeDetail->is_active = 1;
                $propertyTransferredLesseeDetail->created_by = Auth::id();
                $propertyTransferredLesseeDetail->updated_by = Auth::id();
                $propertyTransferredLesseeDetail->save();
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
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::withTrashed()->where('id', $ids[$index])->first();
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
        // Lalit On 09/07/2024 :- Add new lease details while updating MIS property record
        if (isset($request->idNewAdd)) {
            for ($i = 0; $i < count($request->idNewAdd); $i++) {
                $fetchLastRowsPropertyTransferLeaseDetails = PropertyTransferredLesseeDetail::where('id', $request->idNewAdd[$i])->orderBy('id', 'desc')->first();
                for ($j = 0; $j < count($request->input('nameNewAdd' . ($i), [])); $j++) {
                    $propertyTransferredLesseeDetail = new PropertyTransferredLesseeDetail();
                    $propertyTransferredLesseeDetail->property_master_id = $id;
                    $propertyTransferredLesseeDetail->old_property_id = !empty($request->property_id) ? $request->property_id : '';
                    $propertyTransferredLesseeDetail->process_of_transfer = !empty($fetchLastRowsPropertyTransferLeaseDetails->process_of_transfer) ? $fetchLastRowsPropertyTransferLeaseDetails->process_of_transfer : '';
                    $propertyTransferredLesseeDetail->transferDate = !empty($fetchLastRowsPropertyTransferLeaseDetails->transferDate) ? $fetchLastRowsPropertyTransferLeaseDetails->transferDate : Carbon::now()->format('Y-m-d');
                    $propertyTransferredLesseeDetail->lessee_name = !empty($request->input('nameNewAdd' . ($i), [])[$j]) ? $request->input('nameNewAdd' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_age = !empty($request->input('ageNewAdd' . ($i), [])[$j]) ? $request->input('ageNewAdd' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->property_share = !empty($request->input('shareNewAdd' . ($i), [])[$j]) ? $request->input('shareNewAdd' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_pan_no = !empty($request->input('panNumberNewAdd' . ($i), [])[$j]) ? $request->input('panNumberNewAdd' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_aadhar_no = !empty($request->input('aadharNumberNewAdd' . ($i), [])[$j]) ? $request->input('aadharNumberNewAdd' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->batch_transfer_id = $fetchLastRowsPropertyTransferLeaseDetails->batch_transfer_id;
                    $propertyTransferredLesseeDetail->previous_batch_transfer_id = $fetchLastRowsPropertyTransferLeaseDetails->previous_batch_transfer_id;
                    $propertyTransferredLesseeDetail->created_by = Auth::id();
                    $propertyTransferredLesseeDetail->updated_by = Auth::id();
                    $propertyTransferredLesseeDetail->save();
                }
            }
        }
        // Batch transfer details
        $isPrevBatchId = PropertyTransferredLesseeDetail::withTrashed()->where('property_master_id', $id)->max('batch_transfer_id');
        if ($isPrevBatchId > 0) {
            $batch_transfer_id = $isPrevBatchId + 1;
            $previous_batch_transfer_id = $isPrevBatchId;
        } else {
            $batch_transfer_id = 1;
            $previous_batch_transfer_id = null;
        }
        // Code for adding newly added Land Transfer Details by adding multiple more button
        if (isset($request->landTransferTypeNew)) {
            for ($i = 0; $i < count($request->landTransferTypeNew); $i++) {
                for ($j = 0; $j < count($request->input('nameNew' . ($i), [])); $j++) {
                    $propertyTransferredLesseeDetail = new PropertyTransferredLesseeDetail();
                    $propertyTransferredLesseeDetail->property_master_id = $id;
                    $propertyTransferredLesseeDetail->old_property_id = !empty($request->property_id) ? $request->property_id : '';
                    $propertyTransferredLesseeDetail->process_of_transfer = !empty($request->landTransferTypeNew[$i]) ? $request->landTransferTypeNew[$i] : '';
                    $propertyTransferredLesseeDetail->transferDate = !empty($request->transferDateNew[$i]) ? $request->transferDateNew[$i] : Carbon::now()->format('Y-m-d');
                    $propertyTransferredLesseeDetail->lessee_name = !empty($request->input('nameNew' . ($i), [])[$j]) ? $request->input('nameNew' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_age = !empty($request->input('ageNew' . ($i), [])[$j]) ? $request->input('ageNew' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->property_share = !empty($request->input('shareNew' . ($i), [])[$j]) ? $request->input('shareNew' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_pan_no = !empty($request->input('panNumberNew' . ($i), [])[$j]) ? $request->input('panNumberNew' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->lessee_aadhar_no = !empty($request->input('aadharNumberNew' . ($i), [])[$j]) ? $request->input('aadharNumberNew' . ($i), [])[$j] : '';
                    $propertyTransferredLesseeDetail->batch_transfer_id = $batch_transfer_id;
                    $propertyTransferredLesseeDetail->previous_batch_transfer_id = $previous_batch_transfer_id;
                    $propertyTransferredLesseeDetail->created_by = Auth::id();
                    $propertyTransferredLesseeDetail->updated_by = Auth::id();
                    $propertyTransferredLesseeDetail->save();
                }
            }
        }
    }
    //update the property status details
    public function updatePropertyStatusDetails($id, $request, $oldPropertId)
    {
        //dd($request->all());
        $favourOfs = $request->conversion;
        if ($favourOfs) {
            foreach ($favourOfs as $index => $favourOf) {
                if ($favourOf != null) {
                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::withTrashed()->where('id', $index)->first();
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




          // Batch transfer details LAlit - 18/July/2024
          $isPrevBatchId = PropertyTransferredLesseeDetail::withTrashed()->where('property_master_id', $id)->max('batch_transfer_id');
          if ($isPrevBatchId > 0) {
              $batch_transfer_id = $isPrevBatchId + 1;
              $previous_batch_transfer_id = $isPrevBatchId;
          } else {
              $batch_transfer_id = 1;
              $previous_batch_transfer_id = null;
          }
          //For newly added in favour lease details to the PropertyTransferredLesseeDetail model
		  if($request->property_status == 952 && $request->freeHold == 'Yes'){
			$newFavourOfConversions = $request->newInFavourConversion;
			if ($newFavourOfConversions) {
				foreach ($newFavourOfConversions as $index => $newFavourOf) {
				  $propertyTransferredLesseeDetail = new PropertyTransferredLesseeDetail();
				  $propertyTransferredLesseeDetail->property_master_id = $id;
				  $propertyTransferredLesseeDetail->old_property_id = $request->property_id;
				  $propertyTransferredLesseeDetail->process_of_transfer = 'Conversion';
				  $propertyTransferredLesseeDetail->transferDate = $request->date_of_execution;
				  $propertyTransferredLesseeDetail->lessee_name = $newFavourOf;
				  $propertyTransferredLesseeDetail->batch_transfer_id = $batch_transfer_id;
				  $propertyTransferredLesseeDetail->previous_batch_transfer_id = $previous_batch_transfer_id;
				  $propertyTransferredLesseeDetail->is_active = 1;
				  $propertyTransferredLesseeDetail->created_by = Auth::id();
				  $propertyTransferredLesseeDetail->updated_by = Auth::id();
				  $propertyTransferredLesseeDetail->save();
				}
			}
		}





        //update current lessee details
        //Sourav Chauhan - 20 June 2024
        $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $id)->max('batch_transfer_id');
        $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $id)
            ->where('batch_transfer_id', $latestBatchId)
            ->pluck('lessee_name')
            ->toArray();
        $lesseesNames = implode(",", $lesseesWithLatestBatchId);
        $lesseesNames = $lesseesNames ?? '';
        $currentLesseeDetail = CurrentLesseeDetail::where('property_master_id', $id)->first();
        if (!empty($currentLesseeDetail)) {
            if ($currentLesseeDetail['lessees_name'] != $lesseesNames) {
                $currentLesseeDetail->property_status = $request->property_status;
                $currentLesseeDetail->lessees_name = $lesseesNames;
                $currentLesseeDetail->property_known_as = $request->presently_known;
                $currentLesseeDetail->area = $request->area;
                $currentLesseeDetail->unit = $request->area_unit;
                $currentLesseeDetail->area_in_sqm = self::convertToSquareMeter($request->area, $request->area_unit);
                $currentLesseeDetail->save();
            }
        } else {
            $currentLesseeDetail = CurrentLesseeDetail::create([
                'property_master_id' => $id,
                'splited_property_detail_id' => null,
                'old_property_id' => $oldPropertId,
                'property_status' => $request->property_status,
                'lessees_name' => $lesseesNames,
                'property_known_as' => $request->presently_known,
                'area' => $request->area,
                'unit' => $request->area_unit,
                'area_in_sqm' => self::convertToSquareMeter($request->area, $request->area_unit),
                'created_by' => Auth::id()
            ]);
        }

    }
    //update the inspection demand details
    public function updateInspectionDemandDetails($id, $request, $old_property_id)
    {
        $propertyInsDemandDetails = PropertyInspectionDemandDetail::where('property_master_id', $id)->first();
        if (isset($propertyInsDemandDetails)) {
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
        } else {
            if ($request->date_of_last_inspection_report || $request->date_of_last_demand_letter) {
                $PropertyInspectionDemandDetail = new PropertyInspectionDemandDetail;
                $PropertyInspectionDemandDetail->property_master_id = $id;
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
    //update the Miscellaneous details
    public function updateMiscellaneousDetail($id, $request, $old_property_id)
    {
        if($request->supplementary_ground_rent_unit == '1'){
            $gr_in_paisa = $request->supplementary_ground_rent2;
            $gr_in_aana = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_paisa / 100);
        } else{
            $gr_in_aana = $request->supplementary_ground_rent2;
            $gr_in_paisa = null;
            $supplementary_total_gr = $request->supplementary_ground_rent1 + ($gr_in_aana / 16);
        }

        
        if($request->supplementary_premium_unit == '1'){
            $premium_in_paisa = $request->supplementary_premium2;
            $premium_in_aana = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_paisa / 100);
        } else{
            $premium_in_aana = $request->supplementary_premium2;
            $premium_in_paisa = null;
            $supplementary_total_premium = $request->supplementary_premium1 + ($premium_in_aana / 16);
        }
        $supplementary_area_in_sqm = Self::convertToSquareMeter($request->supplementary_area, $request->supplementary_area_unit);

        $propertyMiscDetail = PropertyMiscDetail::where('property_master_id', $id)->first();
        if (isset($propertyMiscDetail)) {
            $oldPropertyMiscDetail = $propertyMiscDetail->getOriginal();
            $propertyMiscDetail->is_gr_revised_ever = $request->GR;
            $propertyMiscDetail->gr_revised_date = $request->gr_revised_date;
            $propertyMiscDetail->is_supplimentry_lease_deed_executed = $request->Supplementary;
            $propertyMiscDetail->supplimentry_lease_deed_executed_date = $request->supplementary_date;

            //added for updating the supplementary details - SOURAV CHAUHAN (12/July/2024)
            $propertyMiscDetail->supplementary_area = $request->supplementary_area;
            $propertyMiscDetail->supplementary_area_unit = $request->supplementary_area_unit;
            $propertyMiscDetail->supplementary_area_in_sqm = $supplementary_area_in_sqm;
            $propertyMiscDetail->supplementary_premium = $request->supplementary_premium1;
            $propertyMiscDetail->supplementary_premium_in_paisa = $premium_in_paisa;
            $propertyMiscDetail->supplementary_premium_in_aana = $premium_in_aana;
            $propertyMiscDetail->supplementary_total_premium = $supplementary_total_premium;
            $propertyMiscDetail->supplementary_gr_in_re_rs = $request->supplementary_ground_rent1;
            $propertyMiscDetail->supplementary_gr_in_paisa = $gr_in_paisa;
            $propertyMiscDetail->supplementary_gr_in_aana = $gr_in_aana;
            $propertyMiscDetail->supplementary_total_gr = $supplementary_total_gr;
            $propertyMiscDetail->supplementary_remark = $request->supplementary_remark;

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
        } else {
            // dd($request->all());
            if ($request->gr_revised_date || $request->supplementary_date || $request->date_of_reentry) {
                $propertyMiscDetail = new PropertyMiscDetail;
                $propertyMiscDetail->property_master_id = $id;
                $propertyMiscDetail->old_property_id = $old_property_id;
                $propertyMiscDetail->is_gr_revised_ever = $request->GR;
                $propertyMiscDetail->gr_revised_date = $request->gr_revised_date;
                $propertyMiscDetail->is_supplimentry_lease_deed_executed = $request->Supplementary;
                $propertyMiscDetail->supplimentry_lease_deed_executed_date = $request->supplementary_date;//added for updating the supplementary details - SOURAV CHAUHAN (12/July/2024)
                $propertyMiscDetail->supplementary_area = $request->supplementary_area;
                $propertyMiscDetail->supplementary_area_unit = $request->supplementary_area_unit;
                $propertyMiscDetail->supplementary_area_in_sqm = $supplementary_area_in_sqm;
                $propertyMiscDetail->supplementary_premium = $request->supplementary_premium1;
                $propertyMiscDetail->supplementary_premium_in_paisa = $premium_in_paisa;
                $propertyMiscDetail->supplementary_premium_in_aana = $premium_in_aana;
                $propertyMiscDetail->supplementary_total_premium = $supplementary_total_premium;
                $propertyMiscDetail->supplementary_gr_in_re_rs = $request->supplementary_ground_rent1;
                $propertyMiscDetail->supplementary_gr_in_paisa = $gr_in_paisa;
                $propertyMiscDetail->supplementary_gr_in_aana = $gr_in_aana;
                $propertyMiscDetail->supplementary_total_gr = $supplementary_total_gr;
                $propertyMiscDetail->supplementary_remark = $request->supplementary_remark;

                $propertyMiscDetail->is_re_rented = $request->Reentered;
                $propertyMiscDetail->re_rented_date = $request->date_of_reentry;
                $propertyMiscDetail->save();
            }
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
    //get old property status
    public function getOldPropertyStatus($propertyId, $request)
    {
        // Property Status Value
        $status = PropertyMaster::where('id', $propertyId)->value('status');
        return $status;
    }
    //Soft delete old property status record on property status dropdown change
    public function softDeleteRecordFromPropertyTransferLeaseDetails($id)
    {
        $pTLDObj = PropertyTransferredLesseeDetail::find($id);
        $pTLDObj->delete();
    }
    public function updateRecordAsNUllInPropertyLeaseDetailsVacant($id)
    {
        $pLDObj = PropertyLeaseDetail::where('property_master_id', $id)->first();
        $pLDObj->in_possession_of_if_vacant = null;
        $pLDObj->date_of_conveyance_deed = null;
        $pLDObj->date_of_transfer = null;
        $pLDObj->save();
    }
    public function updateRecordAsNUllInPropertyLeaseDetailsOthers($id)
    {
        $pLDObj = PropertyLeaseDetail::where('property_master_id', $id)->first();
        $pLDObj->remarks = null;
        $pLDObj->save();
    }

    //Code Done By Lalit on 17/09/2024 Insert record into application_status tabel & section_mis_histories while update MIS
    
    // public function updateContactDetails($id, $request)
    public function insertRecordAppStatusAndSectionMisHis($id, $request,$old_property_id)
    {
        try {
            $serviceType = getServiceType($request->serviceType);
            $modalId = $request->modalId;

            $iseditedOrApprovedEver = SectionMisHistory::where('service_type', $serviceType)
                ->where('model_id', $modalId)
                ->where('property_master_id', $request->masterId)
                ->orderBy('id', 'desc')
                ->first();

            if ($iseditedOrApprovedEver) {
                if ($iseditedOrApprovedEver->is_active == 1 && $iseditedOrApprovedEver->permission_to == Auth::user()->id) {
                    $iseditedOrApprovedEver->is_active = 0;
                    $iseditedOrApprovedEver->save();
                    //Check if record exist in Application status, if yes then update is_mis_checked & mis_checked_by
                    $checkApplicationRecExists = ApplicationStatus::where([['service_type', $serviceType],['model_id', $modalId]])->first();
                    if ($checkApplicationRecExists) {
                        $checkApplicationRecExists->is_mis_checked = true;
                        $checkApplicationRecExists->mis_checked_by = Auth::user()->id;
                        $checkApplicationRecExists->save();
                    }
                } 
            } else {
                $applicantNo = $request->applicantNo;
                $applicationStatus = ApplicationStatus::where('service_type', $serviceType)->where('model_id', $modalId)->first();
                if ($applicationStatus) {
                    $applicationStatus->is_mis_checked = true;
                    $applicationStatus->mis_checked_by = Auth::user()->id;
                    $applicationStatus->save();
                } else {
                    $applicationStatus = ApplicationStatus::create([
                        'service_type' => $serviceType,
                        'model_id' => $modalId,
                        'reg_app_no' => $applicantNo,
                        'is_mis_checked' => true,
                        'mis_checked_by' => Auth::user()->id,
                        'is_scan_file_checked' => false,
                        'is_uploaded_doc_checked' => false,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                if ($applicationStatus) {
                    SectionMisHistory::create([
                        'service_type' => $serviceType,
                        'model_id' => $modalId,
                        'section_code' => trim($request->sectionCode),
                        'old_property_id' => $request->oldPropertyId,
                        'new_property_id' => $request->newPropertyId,
                        'property_master_id' => $request->masterId,
                        'created_by' => Auth::user()->id,
                    ]);
                    
                } 
            }
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }

    //get only two items for flat
    public function getItemsByGroupIdForFlatOnly($id)
    {
        return Group::where('group_id', $id)->with([
            'items' => function ($query) {
                $query->where('is_active', 1)->whereIn('item_code', ['FH', 'LH'])->orderBy('item_order');
                // $query->where('is_active', 1)->whereIn('item_code', ['LH'])->orderBy('item_order');
            }
        ])->get();
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


    //Update Locality, Generated Pid, Section_id in User Registration table while Mis done through It-cell for Manual registration property - Lalit Tiwari (15/jan/2025)
    public function updateUserRegistrationTable($request,$generatedPid){

        //Get Section Id From Property Section Mapping Table - Lalit Tiwari (15/Jan/2025)
        $sectionId = PropertySectionMapping::where([
            'colony_id' => $request->present_colony_name,
            'property_type' => $request->purpose_property_type,
            'property_subtype' => $request->purpose_property_sub_type,
        ])->value('section_id');
        if(empty($sectionId)){
            Log::info("Section Id is not Mapped with Property Mapping for Colony: " . $request->present_colony_name.", Property type : ".$request->purpose_property_type.", Property Sub type : ".$request->purpose_property_sub_type);
            return false;
        }

        //Update Section Id In User Registration Table - Lalit Tiwari (15/Jan/2025)    
        UserRegistration::where('id', $request->regUserId)
            ->update(['generated_pid'=>$generatedPid,'locality' => $request->present_colony_name,'section_id' => $sectionId]);
        
    }

    //Update Locality, Generated Pid, Section_id in New Added Property table while Mis done through It-cell for Manual property added by applicant - Lalit Tiwari (21/jan/2025)
    public function updateNewAddedPropertyTable($request,$generatedPid){

        //Get Section Id From Property Section Mapping Table - Lalit Tiwari (21/Jan/2025)
        $sectionId = PropertySectionMapping::where([
            'colony_id' => $request->present_colony_name,
            'property_type' => $request->purpose_property_type,
            'property_subtype' => $request->purpose_property_sub_type,
        ])->value('section_id');
        if(empty($sectionId)){
            Log::info("Section Id is not Mapped with Property Mapping for Colony: " . $request->present_colony_name.", Property type : ".$request->purpose_property_type.", Property Sub type : ".$request->purpose_property_sub_type);
            return false;
        }

        //Update Locality, Generated Pid, Section_id in New Added Property Table - Lalit Tiwari (21/Jan/2025)    
        NewlyAddedProperty::where('id', $request->newPropUserId)
            ->update(['generated_pid'=>$generatedPid,'locality' => $request->present_colony_name,'section_id' => $sectionId]);
        
    }
}