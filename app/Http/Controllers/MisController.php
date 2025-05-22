<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MisService;
use App\Services\ColonyService;
use App\Services\MisMultiplePropertyService;
use App\Models\PropertyMaster;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\SplitedPropertyDetail;
use App\Models\UserActionLog;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\PropertyInspectionDemandDetail;
use App\Models\PropertyMiscDetail;
use App\Models\PropertyContactDetail;
use App\Models\CurrentLesseeDetail;
use App\Models\PropertyMasterHistory;
use App\Models\PropertyLeaseDetailHistory;
use App\Models\PropertyTransferLesseeDetailHistory;
use App\Models\PropInspDemandDetailHistory;
use App\Models\PropertyContactDetailsHistory;
use App\Models\PropertyMiscDetailHistory;
use App\Models\SplitedPropertyDetailHistory;
use App\Models\ApplicationStatus;
use App\Models\Flat;
use App\Models\NewlyAddedProperty;
use App\Models\SectionMisHistory;
use App\Models\UserRegistration;
use App\Models\Department;
use DB;
// use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PropertySectionMapping;


class MisController extends Controller
{
    public function index(MisService $misService, ColonyService $colonyService,Request $request)
    {
        // Get Registration Id from query params to update locality,generated_pid & section_id in user_registration table when It-Cell Creating Property For Manual Registeration for Property - Lalit Tiwari (15/Jan/2025)
        $regUserId = $newPropUserId = '';
        if (!is_null($request->query('rId'))) {
            $regUserId = $request->query('rId');
        }
        // Get new added property Id from query params to update locality,generated_pid & section_id in newly_added_properties table when It-Cell Creating Property For Manual new property added by applicant - Lalit Tiwari (21/Jan/2025)
        if (!is_null($request->query('uId'))) {
            $newPropUserId = $request->query('uId');
        }

        $colonyList = $colonyService->getColonyList();
        $propertyStatus = $misService->getItemsByGroupId(109);
        $landTypes = $misService->getItemsByGroupId(1051);
        $leaseTypes = $misService->getItemsByGroupId(102);
        $propertyTypes = $misService->getItemsByGroupId(1052);
        $landTransferTypes = $misService->getItemsByGroupId(1057);
        $areaUnit = $misService->getItemsByGroupId(1008);
		$departments = Department::where('is_active',1)->get();
		
        return view('mis', compact(['colonyList', 'propertyStatus', 'landTypes', 'leaseTypes', 'propertyTypes', 'landTransferTypes', 'areaUnit','departments','regUserId','newPropUserId']));
    }
	
	//for storing data for unallocated properties - SOURAV CHAUHAN (06/Dec/2024)
    public function unallottedPropertiesStore(Request $request,MisService $misService){
        //validation rules
        $rules = [
            'property_id' => 'unique:property_masters,old_propert_id|unique:splited_property_details,old_property_id',
            'file_number' => 'required',
            'present_colony_name' => 'required',
            'old_colony_name' => 'required',
            'property_status' => 'required',
            'land_type' => 'required',
            'plot_no' => 'required',
            'area' => 'required',
            'area_unit' => 'required',
            'islitigation' => 'required',
            'isencroachment' => 'required',
            'landparceltype' => 'required'
        ];

        //Validation
        $validated = $request->validate($rules);
        //try {
            $response = $misService->storeUnallottedMisData($request);
            if ($response === true) {
                // Transaction was successful
                return redirect()->back()->with('success', 'Property details saved successfully.');
            } else if ($response == false) {
                // Transaction failed
                return redirect()->back()->with('failure', 'Property details not saved');
            } else {
                return redirect()->back()->with('failure', $response);
            }

       /*  } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('failure', $e->getMessage());
         } */
    }

    public function misFormMultiple(MisService $misService, ColonyService $colonyService)
    {

        $colonyList = $colonyService->getColonyList();
        $propertyStatus = $misService->getItemsByGroupId(109);
        $landTypes = $misService->getItemsByGroupId(1051);
        $leaseTypes = $misService->getItemsByGroupId(102);
        $propertyTypes = $misService->getItemsByGroupId(1052);
        $landTransferTypes = $misService->getItemsByGroupId(1057);
        $areaUnit = $misService->getItemsByGroupId(1008);

        return view('mis.multiple-property', compact(['colonyList', 'propertyStatus', 'landTypes', 'leaseTypes', 'propertyTypes', 'landTransferTypes', 'areaUnit']));
    }

    public function prpertySubTypes(Request $request, MisService $misService)
    {
        $subTypes = $misService->getRelatedSubTypes($request);
        return response()->json($subTypes);

    }

    //store the MIS Form data
    public function store(Request $request, MisService $misService)
    {

        //validation rules
        $rules = [
            'property_id' => 'unique:property_masters,old_propert_id|unique:splited_property_details,old_property_id',
            'file_number' => 'required',
            'present_colony_name' => 'required',
            'old_colony_name' => 'required',
            'property_status' => 'required',
            'land_type' => 'required',
            // 'transferred' => 'required',//as its not required 18 april 2024
            'address' => 'required',
            'GR' => 'required',
            'Supplementary' => 'required',
            'Reentered' => 'required'
        ];


        //Validation msssages
        $messages = [
            'property_id' => 'Property Id already saved earlier',
            'file_number' => 'File Number is required',
            // 'transferred.required' => 'Please specify property is transferred or not',
            'address' => 'Address is required',
            'GR' => 'Please specify GR ever revised or not',
            'Supplementary' => 'Please specify supplementary lease deed executed or not',
            'Reentered' => 'Please specify property re-entered or not',
        ];


        //Validation
        $validated = $request->validate($rules, $messages);

        try {
            $response = $misService->storeMisData($request);

            if ($response) {
                // Transaction was successful
                return redirect()->back()->with('success', 'Property details saved successfully.');
            } else if ($response == false) {
                // Transaction failed
                return redirect()->back()->with('failure', 'Property details not saved');
            } else {
                return redirect()->back()->with('failure', $response);
            }
            //dd($response);

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }

    public function misStoreMultiple(Request $request, MisMultiplePropertyService $misMultiplePropertyService)
    {
        //validation rules
        $rules = [
            'property_id' => 'unique:property_masters,old_propert_id|unique:splited_property_details,old_property_id',
            'file_number' => 'required',
            'present_colony_name' => 'required',
            'old_colony_name' => 'required',
            'property_status' => 'required',
            'land_type' => 'required',
        ];


        //Validation msssages
        $messages = [
            'property_id' => 'Property Id already saved earlier',
            'file_number' => 'File Number is required',
        ];


        //Validation
        $validated = $request->validate($rules, $messages);

        try {
            $response = $misMultiplePropertyService->storeMisMultipleData($request);

            if ($response) {
                // Transaction was successful
                return redirect()->back()->with('success', 'Property details saved successfully.');
            } else if ($response == false) {
                // Transaction failed
                return redirect()->back()->with('failure', 'Property details not saved');
            } else {
                return redirect()->back()->with('failure', $response);
            }
            //dd($response);

        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }


    // public function propertDetails(MisService $misService)
    // {
    //     $propertyDetails = $misService->propertDetails();
    //     $item = new Item();
    //     $user = new User();
    //     return view('mis.details', compact(['propertyDetails', 'item', 'user']));
    // }
    public function propertDetails(Request $request, MisService $misService, ColonyService $colonyService)
    {
        $userId = Auth::id();
        $user = Auth::user();

        // for showing section assigned properties only
        $colonyList = $colonyService->sectionWiseColonies();
        $loginUserSections = $user->sections;
        $allSections = [];
        $allSectionIds = [];
        $allTypes = [];
        $allSubTypes = [];
        foreach($loginUserSections as $loginUserSection){
            $sectionCode = $loginUserSection->section_code;
            $allSections[] = $sectionCode;
            $sectionId = $loginUserSection->id;
            $allSectionIds[] = $sectionId;
        }
        $propertySectionMappings = PropertySectionMapping::whereIn('section_id',$allSectionIds)->get();
        foreach($propertySectionMappings as $propertySectionMapping){
            $type = $propertySectionMapping->property_type;
            $allTypes[] = $type;
            $subType = $propertySectionMapping->property_subtype;
            $allSubTypes[] = $subType;
        }
        if ($user->can('view.all.details')) {
            if($user->roles[0]->id == 7 || $user->roles[0]->id == 8 || $user->roles[0]->id == 9 || $user->roles[0]->id == 10){
                $dataWithPagination = PropertyMaster::query()->whereIn('section_code',$allSections)->whereIn('property_type',$allTypes)->whereIn('property_sub_type',$allSubTypes)->latest()->paginate(20);
            } else {
                $dataWithPagination = PropertyMaster::query()->latest()->paginate(20);
            }
        } else {
            // $misData = PropertyMaster::where('created_by', $userId)->latest()->get();
            $dataWithPagination = PropertyMaster::where('created_by', $userId)->latest()->paginate(20);
        }

        // $colonyList = $colonyService->misDoneForColonies();
        // if ($user->can('view.all.details')) {
        //     // $misData = PropertyMaster::latest()->get();
        //     $dataWithPagination = PropertyMaster::query()->latest()->paginate(20);
        // } else {
        //     // $misData = PropertyMaster::where('created_by', $userId)->latest()->get();
        //     $dataWithPagination = PropertyMaster::where('created_by', $userId)->latest()->paginate(20);
        // }

        $item = new Item();
        $user = Auth::user();
        if ($request->ajax()) {
            if ($user->can('view.all.details')) {
                if($user->roles[0]->id == 7 || $user->roles[0]->id == 8 || $user->roles[0]->id == 9 || $user->roles[0]->id == 10){
                    
                    $dataWithSectionFilter = PropertyMaster::query()->whereIn('section_code',$allSections)->whereIn('property_type',$allTypes)->whereIn('property_sub_type',$allSubTypes);
                } else {
                    $dataWithSectionFilter = PropertyMaster::query();
                }
                $dataWithPagination = $dataWithSectionFilter->when($request->seach_term, function ($q) use ($request) {
                        $q->where('old_propert_id', 'like', '%' . $request->seach_term . '%');
                            // ->orWhere('unique_propert_id', 'like', '%' . $request->seach_term . '%');

                    })
                    ->when($request->date && $request->dateEnd, function ($q) use ($request) {
                        $q->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->date)))
                            ->where('created_at', '<=', date('Y-m-d 23:59:00', strtotime($request->dateEnd)));
                    })
                    ->when($request->date, function ($q) use ($request) {
                        $q->whereDate('created_at', '=', date('Y-m-d', strtotime($request->date)));
                    })
                    ->latest()->paginate(20);

            } else {
                $dataWithPagination = PropertyMaster::query()
                    ->when($request->seach_term, function ($q) use ($request) {
                        $q->where('old_propert_id', 'like', '%' . $request->seach_term . '%');
                            // ->orWhere('unique_propert_id', 'like', '%' . $request->seach_term . '%');
                    })
                    ->when($request->date && $request->dateEnd, function ($q) use ($request) {
                        $q->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->date)))
                            ->where('created_at', '<=', date('Y-m-d 23:59:00', strtotime($request->dateEnd)));
                    })
                    ->when($request->date, function ($q) use ($request) {
                        $q->whereDate('created_at', '=', date('Y-m-d', strtotime($request->date)));
                    })
                    ->where('created_by', $userId)->latest()->paginate(20);
            }
            return view('mis.pagination_child', compact(['item', 'user', 'dataWithPagination', 'colonyList']))->render();
        }
        return view('mis.details', compact(['item', 'user', 'dataWithPagination', 'colonyList']));
    }

//for checking property is available in the assigned section of user or not - SOURAV CHAUHAN (30/Dec/2024)
    public function isMisPropertyAvailable(Request $request){
        $isPropertyAvailable = PropertyMaster::where('old_propert_id', 'like', '%' . $request->search_term . '%')
        // ->orWhere('unique_propert_id', 'like', '%' . $request->search_term . '%')
        ->first();
        if($isPropertyAvailable){
            $user = Auth::user();
            $loginUserSections = $user->sections;
            $allSections = [];
            foreach($loginUserSections as $loginUserSection){
                $sectionCode = $loginUserSection->section_code;
                $allSections[] = $sectionCode;
            }
            if (in_array(str_replace(' ', '', $isPropertyAvailable->section_code), $allSections)){


                $response = ['status' => true, 'message' => 'Property Id avialable'];
            } else {
                if($user->roles[0]->id == 7 || $user->roles[0]->id == 8 || $user->roles[0]->id == 10){
                    $response = ['status' => false, 'message' => 'Property Id not belongs to your sections'];
                } else {

                    $response = ['status' => false];
                }
            }
        } else {
            $response = ['status' => false, 'message' => 'Property Id not avialable'];
        }
        return json_encode($response);   
    }


    public function propertyChildDetails($id, MisService $misService)
    {
        $item = new Item();
        $propertyChildDetails = $misService->propertyChildDetails($id);
        $viewDetails = $propertyChildDetails['ParentData'];
        $childData = $propertyChildDetails['childData'];
        $separatedData = [];
        // foreach ($childData->propertyTransferredLesseeDetails as $transferDetail) {

        //     $processOfTransfer = $transferDetail->process_of_transfer;

        //     // Check if the process_of_transfer value is already a key in $separatedData
        //     if (!array_key_exists($processOfTransfer, $separatedData)) {
        //         // If not, create a new array for this process_of_transfer value
        //         $separatedData[$processOfTransfer] = [];
        //     }

        //     // Add the current $transferDetail to the corresponding array in $separatedData
        //     $separatedData[$processOfTransfer][] = $transferDetail;
        // }
        // added for showing same precess seperatly if eecuted on different dates;
        $separatedData = self::getSeparatedPropertyTransferDetails($childData->propertyTransferredLesseeDetails);
        return view('mis.child-preview', compact(['viewDetails', 'item', 'separatedData', 'childData']));


    }



    //for single property full details page
    public function viewDetails($property, MisService $misService, Request $request)
    {
        //Start :- code added on 31 dec for view property details after migratting is_mis,scanned,upload file checked by lalit tiwari
        // Retrieve the user's roles
        $roles = Auth::user()->roles[0]->name;
        $additionalDataJson = $request->query('params');

        $isChecked = 0;
        $additionalData =  $flatData['flatDetails'] = [];
        $disableButtons = false;
        $disableApproveButtons = $hideRequestEditButtons =  true;

        if (isset($additionalDataJson)) {
            $additionalData = json_decode($additionalDataJson, true);
            $serviceType = getServiceType($additionalData[0]);
            //Get Flat Details - Lalit Tiwari (15/Oct/2024)
            if (!empty($additionalData[7])) {
                $flatDetails = Flat::find($additionalData[7]);
                $flatData['flatDetails'] = $flatDetails;
                $flatData['flatDetails']['flat_id'] = $flatDetails->id;
                $flatData['flatDetails']['is_property_flat'] = 1;
            } else {
                if (!empty($additionalData[2])) {
                    if ($additionalData[0] == 'RS_NEW_REG') {
                        $uRegData = UserRegistration::where('applicant_number', $additionalData[2])->first();
                    } else {
                        $uRegData = NewlyAddedProperty::where([
                            ['id', $additionalData[1]],
                            ['applicant_number', $additionalData[2]],
                            ['old_property_id', $additionalData[5]],
                        ])->first();
                    }
                    if (!empty($uRegData) && $uRegData->is_property_flat) {
                        if (!empty($uRegData->flat_id)) {
                            $flatDetails = Flat::find($uRegData->flat_id);
                            $flatData['flatDetails']['flat_id'] = $flatDetails->id;
                            $flatData['flatDetails'] = $flatDetails;
                        } else {
                            if (!empty($uRegData->flat_no) && !empty($additionalData[3])) {
                                $flatDetails = Flat::where([
                                    ['property_master_id', $additionalData[3]],
                                    ['locality', $uRegData->locality],
                                    ['block', $uRegData->block],
                                    ['plot', $uRegData->plot],
                                    ['flat_number', $uRegData->flat_no],
                                ])->first();
                                if (!empty($flatDetails)) {
                                    $flatData['flatDetails'] = $flatDetails;
                                    $flatData['flatDetails']['flat_id'] = $flatDetails->id;
                                    $flatData['flatDetails']['flat_number'] = $flatDetails->flat_number;
                                    $disableButtons = false;
                                    $hideRequestEditButtons = true;
                                } else {
                                    $flatData['flatDetails']['flat_number'] = $uRegData->flat_no;
                                    $flatData['flatDetails']['flat_id'] = '';
                                    $disableButtons = false;
                                    $disableApproveButtons = false;
                                    $hideRequestEditButtons = false;
                                }
                            }
                        }
                        $flatData['flatDetails']['is_property_flat'] = 1;
                    } else {
                        $flatData['flatDetails']['is_property_flat'] = 0;
                    }
                }
            }

            $isChecked = 1;
            if (!empty($additionalData[7])) {
                $applicationStatus = SectionMisHistory::where('service_type', $serviceType)
                    ->where('model_id', $additionalData[1])
                    ->where('property_master_id', $property)
                    ->where('flat_id', $additionalData[7])
                    ->orderBy('id', 'desc')
                    ->first();
            } else {

                $applicationStatus = SectionMisHistory::where('service_type', $serviceType)
                    ->where('model_id', $additionalData[1])
                    ->where('property_master_id', $property)
                    ->orderBy('id', 'desc')
                    ->first();
            }
            if ($applicationStatus) {
                //Lalit (18/09/2024) :- Check if Edit Request is active, so disable approve button
                $checkEditRequestexists = SectionMisHistory::where([['section_code', $applicationStatus->section_code], ['old_property_id', $applicationStatus->old_property_id], ['is_active', $applicationStatus->is_active]])->exists();
                if ($checkEditRequestexists) {
                    $disableApproveButtons = false;
                }

                if ($additionalData[0] === 'RS_NEW_REG') {
                    //Lalit (18/09/2024) :- Check if User Registration is approved, so hide request edit button
                    $checkRegistrationStatus = UserRegistration::with('item')->where('id', $applicationStatus->model_id)->first();
                    if ($checkRegistrationStatus && $checkRegistrationStatus->item->item_code == 'RS_APP') {
                        $hideRequestEditButtons = false;
                    }
                }

                if ($additionalData[0] === 'RS_NEW_PRO') {
                    //Lalit (03/10/2024) :- Check if User Registration is approved, so hide request edit button
                    $checkNewPropertyStatus = NewlyAddedProperty::with('item')->where('id', $applicationStatus->model_id)->first();
                    if ($checkNewPropertyStatus && $checkNewPropertyStatus->item->item_code == 'RS_APP') {
                        $hideRequestEditButtons = false;
                    }
                }


                if ($applicationStatus->is_active == 1) {

                    $permissionTo = User::find($applicationStatus->permission_to);
                    $permissionTosection = $permissionTo->sections;

                    $loginUser = User::find(Auth::user()->id);
                    $loginUsersection = $loginUser->sections;

                    $permissionTosectionCodes = $permissionTosection->pluck('section_code')->toArray();
                    $loginUsersectionCodes = $loginUsersection->pluck('section_code')->toArray();

                    $commonSectionCodes = array_intersect($permissionTosectionCodes, $loginUsersectionCodes);

                    if (!empty($commonSectionCodes)) {
                        $disableButtons = false;
                    } else {
                        $disableButtons = true;
                    }
                } else {

                    $disableButtons = true;
                }
            }

            // Add user action logs for mis details checked by user - Lalit (28/Oct/2024)
            $property_id_link = '<a href="' . url("/property-details/{$property}/view") . '" target="_blank">' . $property . '</a>';
            UserActionLogHelper::UserActionLog('mis_checked', url("/property-details/$property/view"), 'propertyProfarma', "Property mis details " . $property_id_link . " has been checked by user " . Auth::user()->name . ".");
        } else {
            $applicationStatus = '';
        }

        //End :- code added on 31 dec for view property details after migratting is_mis,scanned,upload file checked by lalit tiwari





        $item = new Item();
        $viewDetails = $misService->viewDetails($property);
        $separatedData = [];

        // foreach ($viewDetails->propertyTransferredLesseeDetails as $transferDetail) {
        //     $processOfTransfer = $transferDetail->process_of_transfer;
        //     $dateOfTransfer = $transferDetail->transferDate;


        //     // Check if the process_of_transfer value is already a key in $separatedData
        //     if (!array_key_exists($processOfTransfer, $separatedData)) {
        //         // If not, create a new array for this process_of_transfer value
        //         $separatedData[$processOfTransfer] = [];
        //     }
        //     /** Added By Nitin to grup transfers by date */
        //     if (!array_key_exists($dateOfTransfer, $separatedData[$processOfTransfer])) {
        //         $separatedData[$processOfTransfer][$dateOfTransfer] = [];
        //     }
        //     /**  ====================added by Nitin */

        //     // Add the current $transferDetail to the corresponding array in $separatedData
        //     $separatedData[$processOfTransfer][$dateOfTransfer][] = $transferDetail;  // modified by Nitin
        // }

        $separatedData = self::getSeparatedPropertyTransferDetails($viewDetails->propertyTransferredLesseeDetails->where('splited_property_detail_id', null));
        // return view('mis.preview', compact(['viewDetails', 'item', 'separatedData']));
        return view('mis.preview', compact(['viewDetails', 'item', 'separatedData', 'isChecked', 'additionalData', 'disableButtons', 'applicationStatus', 'disableApproveButtons', 'hideRequestEditButtons', 'flatData', 'roles']));
    }

    public function editDetails(Request $request, $id, MisService $misService, ColonyService $colonyService)
    {
        //Added by Lalit on 17/09/2024 Get Additional data from url as query params to get inserted into application_status & section_mis_histories
        $additionalDataJson = $request->query('params');
        // Decode only if query parameter exists; otherwise, set an empty array
        $additionalData = $additionalDataJson ? json_decode($additionalDataJson, true) : [];

        $propertyDetail = $misService->viewDetails($id);
        $separatedData = [];
        // foreach ($propertyDetail->propertyTransferredLesseeDetails as $transferDetail) {
        //     $processOfTransfer = $transferDetail->process_of_transfer;

        //     // Check if the process_of_transfer value is already a key in $separatedData
        //     if (!array_key_exists($processOfTransfer, $separatedData)) {
        //         // If not, create a new array for this process_of_transfer value
        //         $separatedData[$processOfTransfer] = [];
        //     }

        //     // Add the current $transferDetail to the corresponding array in $separatedData
        //     $separatedData[$processOfTransfer][] = $transferDetail;
        // }

        $separatedData = self::getSeparatedPropertyTransferDetails($propertyDetail->propertyTransferredLesseeDetails->where('splited_property_detail_id', null), true);
        //Lease Details
        $propertyLeaseDetail = $propertyDetail->propertyLeaseDetail;
        //dd($propertyLeaseDetail);

        //Tranfer Lessee Details
        if (isset($separatedData['Original'])) {
            $original = $separatedData['Original'];
        } else {
            $original = [];
        }

        //dd($original);
        if (isset($separatedData['Conversion'])) {
            $conversion = $separatedData['Conversion'];
        } else {
            $conversion = [];
        }

        $keysToRemove = ['Original', 'Conversion'];
        $filteredTransferDetails = collect($separatedData)->except($keysToRemove)->toArray();
        $colonyList = $colonyService->getColonyList();
        $propertyStatus = $misService->getItemsByGroupId(109);
        $landTypes = $misService->getItemsByGroupId(1051);
        $leaseTypes = $misService->getItemsByGroupId(102);
        $propertyTypes = $misService->getItemsByGroupId(1052);
        $landTransferTypes = $misService->getItemsByGroupId(1057);
        $areaUnit = $misService->getItemsByGroupId(1008);

        //SubTypes Old
        $propertytypeSubtpeMapping = DB::table('property_type_sub_type_mapping')->where('type', $propertyLeaseDetail->property_type_as_per_lease)->get();
        $subTypeIds = [];
        foreach ($propertytypeSubtpeMapping as $data) {
            $subTypeId = $data->sub_type;
            $subTypeIds[] = $subTypeId;
        }
        $subTypes = Item::whereIn('id', $subTypeIds)->get();


        //SubTypes Old if land transfered
        $subTypesNew = '';
        if ($propertyLeaseDetail->is_land_use_changed) {
            $propertytypeSubtpeMappingNew = DB::table('property_type_sub_type_mapping')->where('type', $propertyLeaseDetail->property_type_at_present)->get();
            $subTypeIdsNew = [];
            foreach ($propertytypeSubtpeMappingNew as $dataNew) {
                $subTypeId = $dataNew->sub_type;
                $subTypeIdsNew[] = $subTypeId;
            }
            $subTypesNew = Item::whereIn('id', $subTypeIdsNew)->get();
        }

        //Property Inspection and Demand Details
        $propertyInspectionDemandDetail = $propertyDetail->propertyInspectionDemandDetail;

        //Property Misc Details
        $propertyMiscDetail = $propertyDetail->propertyMiscDetail;

        //Property Contact Details
        $propertyContactDetail = $propertyDetail->propertyContactDetail;

        return view('mis.edit', compact(['colonyList', 'propertyStatus', 'landTypes', 'leaseTypes', 'propertyTypes', 'landTransferTypes', 'areaUnit', 'propertyDetail', 'original', 'conversion', 'propertyLeaseDetail', 'subTypes', 'subTypesNew', 'filteredTransferDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'additionalData']));
    }

    public function editChildDetails($id, MisService $misService, ColonyService $colonyService)
    {
        $childDetails = SplitedPropertyDetail::where('id', $id)->first();
        $parentId = $childDetails['property_master_id'];
        $propertyDetail = $misService->viewDetails($parentId);
        $separatedData = [];
        // foreach ($childDetails->propertyTransferredLesseeDetails as $transferDetail) {
        //     $processOfTransfer = $transferDetail->process_of_transfer;

        //     // Check if the process_of_transfer value is already a key in $separatedData
        //     if (!array_key_exists($processOfTransfer, $separatedData)) {
        //         // If not, create a new array for this process_of_transfer value
        //         $separatedData[$processOfTransfer] = [];
        //     }

        //     // Add the current $transferDetail to the corresponding array in $separatedData
        //     $separatedData[$processOfTransfer][] = $transferDetail;
        // }

        //added by sourav - 29/july/2024
        $separatedData = self::getSeparatedPropertyTransferDetails($childDetails->propertyTransferredLesseeDetails, true);

        //Lease Details
        $propertyLeaseDetail = $propertyDetail->propertyLeaseDetail;
        //dd($propertyLeaseDetail);
        //Tranfer Lessee Details
        if (isset($separatedData['Original'])) {
            $original = $separatedData['Original'];
        } else {
            $original = [];
        }

        //dd($original);
        if (isset($separatedData['Conversion'])) {
            $conversion = $separatedData['Conversion'];
        } else {
            $conversion = [];
        }


        $keysToRemove = ['Original', 'Conversion'];
        $filteredTransferDetails = collect($separatedData)->except($keysToRemove)->toArray();
        //dd($filteredTransferDetails);

        $colonyList = $colonyService->getColonyList();
        $propertyStatus = $misService->getItemsByGroupId(109);
        $landTypes = $misService->getItemsByGroupId(1051);
        $leaseTypes = $misService->getItemsByGroupId(102);
        $propertyTypes = $misService->getItemsByGroupId(1052);
        $landTransferTypes = $misService->getItemsByGroupId(1057);
        $areaUnit = $misService->getItemsByGroupId(1008);

        //SubTypes Old
        $propertytypeSubtpeMapping = DB::table('property_type_sub_type_mapping')->where('type', $propertyLeaseDetail->property_type_as_per_lease)->get();
        $subTypeIds = [];
        foreach ($propertytypeSubtpeMapping as $data) {
            $subTypeId = $data->sub_type;
            $subTypeIds[] = $subTypeId;
        }
        $subTypes = Item::whereIn('id', $subTypeIds)->get();


        //SubTypes Old if land transfered
        $subTypesNew = '';
        if ($propertyLeaseDetail->is_land_use_changed) {
            $propertytypeSubtpeMappingNew = DB::table('property_type_sub_type_mapping')->where('type', $propertyLeaseDetail->property_type_at_present)->get();
            $subTypeIdsNew = [];
            foreach ($propertytypeSubtpeMappingNew as $dataNew) {
                $subTypeId = $dataNew->sub_type;
                $subTypeIdsNew[] = $subTypeId;
            }
            $subTypesNew = Item::whereIn('id', $subTypeIdsNew)->get();
        }

        //Property Inspection and Demand Details
        $propertyInspectionDemandDetail = $childDetails->propertyInspectionDemandDetail;

        //Property Misc Details
        $propertyMiscDetail = $childDetails->propertyMiscDetail;

        //Property Contact Details
        $propertyContactDetail = $propertyDetail->propertyContactDetail;
        $childContactDetail = $childDetails->propertyContactDetail;


        return view('mis.edit-multiple', compact(['colonyList', 'propertyStatus', 'landTypes', 'leaseTypes', 'propertyTypes', 'landTransferTypes', 'areaUnit', 'propertyDetail', 'original', 'conversion', 'propertyLeaseDetail', 'subTypes', 'subTypesNew', 'filteredTransferDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'childContactDetail', 'childDetails']));
    }

    // Delete Leasee details in favour of
    public function destroyOriginalById($id, Request $request, MisService $misService)
    {
        if (!empty($id)) {
            $result = $misService->delete($id, $request);
            if ($result) {
                $response = ['status' => true, 'message' => 'Original lease details ' . $id . ' successfully in-activated.'];
            } else {
                $response = ['status' => false, 'message' => 'Original lease details ID is wrong.', 'data' => NULL];
            }
            return json_encode($response);
        }
    }

    // Delete Land transfer through batch id
    public function destroyLandTransferByBatchId($batchTransferId, $propertyMasterId, Request $request, MisService $misService)
    {
        if (!empty($batchTransferId) && !empty($propertyMasterId)) {

            $result = $misService->deleteLandTransferByBatchId($batchTransferId, $propertyMasterId, $request);
            if ($result) {
                $response = ['status' => true, 'message' => 'Land Transfer lease details ' . $batchTransferId . ' successfully in-activated.'];
            } else {
                $response = ['status' => false, 'message' => 'Land Transfer details ID is wrong.', 'data' => NULL];
            }
            return json_encode($response);
        }
    }

    // Delete Land transfer through unique id
    public function destroyLandTransferByIndividualId($landTransferId, $batchTransferId, $propertyMasterId, Request $request, MisService $misService)
    {
        if (!empty($landTransferId) && !empty($batchTransferId) && !empty($propertyMasterId)) {

            $result = $misService->delete($landTransferId, $request);
            if ($result) {
                // //Check if more record exist with same batch id
                $isExist = $misService->checkMoreRecordExistForBatchId($batchTransferId, $propertyMasterId, $request);
                if ($isExist) {
                    $response = ['status' => true, 'message' => 'Land Transfer lease details ' . $batchTransferId . ' successfully in-activated.', 'data' => 'exist'];
                } else {
                    $response = ['status' => true, 'message' => 'Land Transfer lease details ' . $batchTransferId . ' successfully in-activated.', 'data' => 'notexist'];
                }
                // $response = ['status' => true, 'message' => 'Land Transfer lease details ' . $batchTransferId . ' successfully in-activated.'];
            } else {
                $response = ['status' => false, 'message' => 'Land Transfer details ID is wrong.', 'data' => 'notexist'];
            }
            return json_encode($response);
        }
    }

    // get old property id record
    public function getOldPropertyStatusValue($propertyId, $propertyStatusId, Request $request, MisService $misService)
    {
        if (!empty($propertyId) && !empty($propertyStatusId)) {

            $oldStatusId = $misService->getOldPropertyStatus($propertyId, $request);
            if (!empty($oldStatusId) && !empty($propertyStatusId) && ($oldStatusId != $propertyStatusId)) {
                $response = ['status' => true, 'message' => 'Property id is different', 'data' => 'true', 'oldStatusId' => $oldStatusId];
            } else {
                $response = ['status' => true, 'message' => 'Property id is same', 'data' => 'false'];
            }
            return json_encode($response);
        }
    }

    public function softDeleteOldPropertyStatusRecord(Request $request, MisService $misService)
    {
        if (!empty($request->oldPropertyDbStatusId) && ($request->oldPropertyDbStatusId == 952) && !empty($request->conversion)) {
            foreach ($request->conversion as $id => $name) {
                $misService->softDeleteRecordFromPropertyTransferLeaseDetails($id);
            }
        } else if (!empty($request->oldPropertyDbStatusId) && ($request->oldPropertyDbStatusId == 1124) && !empty($request->propertyId)) {
            $misService->updateRecordAsNUllInPropertyLeaseDetailsVacant($request->propertyId);
        } else if (!empty($request->oldPropertyDbStatusId) && ($request->oldPropertyDbStatusId == 1342) && !empty($request->propertyId)) {
            $misService->updateRecordAsNUllInPropertyLeaseDetailsOthers($request->propertyId);
        }
        return response()->json(['success' => true, 'message' => 'soft deleted successfully.']);
    }

    public function update($id, Request $request, MisService $misService)
    {
        $response = $misService->update($id, $request);
        if ($response) {
            // Transaction was successful
            return redirect()->back()->with('success', 'Property details Updated successfully.');
        } else if ($response == false) {
            // Transaction failed
            return redirect()->back()->with('failure', 'Property details not updated');
        } else {
            return redirect()->back()->with('failure', $response);
        }
    }

    /** function added by nitin  -  to get seprataed details */

    private function getSeparatedPropertyTransferDetails($rows, $editing = false)
    {
        $separatedData = [];
        $keysToRemove = $editing ? ['Original', 'Conversion'] : []; // if not editing then do not remove any process types
        foreach ($rows as $transferDetail) {
            //added for only showing parent details - SOURAV CHAUHAN (19/July/2024)
            $propertyDetails = PropertyMaster::where('id', $transferDetail->property_master_id)->first();
            if ($transferDetail->splited_property_detail_id == null) {
                $processOfTransfer = $transferDetail->process_of_transfer;
                $dateOfTransfer = $transferDetail->transferDate; //Added By Nitin
                if (!in_array($processOfTransfer, $keysToRemove)) {
                    // Check if the process_of_transfer value is already a key in $separatedData
                    if (!array_key_exists($dateOfTransfer, $separatedData)) {
                        // If not, create a new array for this process_of_transfer value
                        $separatedData[$dateOfTransfer] = [];
                    }

                    if (!array_key_exists($processOfTransfer, $separatedData[$dateOfTransfer])) {
                        $separatedData[$dateOfTransfer][$processOfTransfer] = [];
                    }

                    // Add the current $transferDetail to the corresponding array in $separatedData
                    $separatedData[$dateOfTransfer][$processOfTransfer][] = $transferDetail;  // modified by Nitin}

                } else { //original and conversoin processes are handled sapearately in case of edit
                    if (!array_key_exists($processOfTransfer, $separatedData)) {
                        $separatedData[$processOfTransfer] = [];
                    }

                    // Add the current $transferDetail to the corresponding array in $separatedData
                    $separatedData[$processOfTransfer][] = $transferDetail;  // modified by Nitin}
                }
            } else {
                $processOfTransfer = $transferDetail->process_of_transfer;
                $dateOfTransfer = $transferDetail->transferDate; //Added By Nitin
                if (!in_array($processOfTransfer, $keysToRemove)) {
                    // Check if the process_of_transfer value is already a key in $separatedData
                    if (!array_key_exists($dateOfTransfer, $separatedData)) {
                        // If not, create a new array for this process_of_transfer value
                        $separatedData[$dateOfTransfer] = [];
                    }
                    if (!array_key_exists($processOfTransfer, $separatedData[$dateOfTransfer])) {
                        $separatedData[$dateOfTransfer][$processOfTransfer] = [];
                    }
                    // Add the current $transferDetail to the corresponding array in $separatedData
                    $separatedData[$dateOfTransfer][$processOfTransfer][] = $transferDetail;  // modified by Nitin}
                } else { //original and conversoin processes are handled sapearately in case of edit
                    if (!array_key_exists($processOfTransfer, $separatedData)) {
                        $separatedData[$processOfTransfer] = [];
                    }
                    // Add the current $transferDetail to the corresponding array in $separatedData
                    $separatedData[$processOfTransfer][] = $transferDetail;  // modified by Nitin}
                }

            }
        }
        // dd($separatedData);
        ksort($separatedData);
        return $separatedData;
    }


    public function updateChild($id, Request $request, MisMultiplePropertyService $misMultiplePropertyService)
    {
        //Validation
        $response = $misMultiplePropertyService->updateChild($id, $request);
        if ($response) {
            // Transaction was successful
            return redirect()->back()->with('success', 'Property details Updated successfully.');
        } else if ($response == false) {
            // Transaction failed
            return redirect()->back()->with('failure', 'Property details not updated');
        } else {
            return redirect()->back()->with('failure', $response);
        }
    }
    

    //Get user action log details Lalit On 18/07/2024
    public function actionLogListings(Request $request)
    {
        if ($request->ajax()) {
            // $data = UserActionLog::with(['user', 'module'])
            //     ->whereDate('created_at', Carbon::today())
            //     ->orderBy('created_at', 'desc')->get();
            $query = UserActionLog::with(['user', 'module'])
                ->orderBy('created_at', 'desc');
            if ($request->has('start_date') && $request->has('end_date')) {
                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$start_date, $end_date]);
            } else {
                $query->whereDate('created_at', Carbon::today());
            }
            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    // if (!empty($request->get('email'))) {
                    //     $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //         return Str::contains($row['email'], $request->get('email')) ? true : false;
                    //     });
                    // }
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['user_name']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['module_name']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['action']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['description']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['created_at']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                // ->addColumn('action', function($row){
                //        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                //         return $btn;
                // })
                ->addColumn('user_name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('module_name', function ($row) {
                    return $row->module->name;
                })
                ->editColumn('description', function ($row) {
                    // Assuming description contains the HTML for the anchor tag
                    return $row->description;
                })
                ->rawColumns(['description'])
                ->make(true);
        }
        return view('user-action-logs.index');
    }

      //Swati Mishra for Downloading Pdf of Detailed Report
      public function viewPropertyDetails($property, MisService $misService)
    {
        $item = new Item();
        $viewDetails = $misService->viewDetails($property);

        // code modified by nitin created new function to ge sapated data;
        $separatedData = self::getSeparatedPropertyTransferDetails($viewDetails->propertyTransferredLesseeDetails);

        // 🔁 Demand Fallback: always fetch from API using ReportController
        $demandFallback = null;
        $fakeRequest = new Request(['property_id' => $viewDetails->old_propert_id]);
        $demandResponse = app(ReportController::class)->getDemandDetails($fakeRequest)->getData();

        if ($demandResponse->status) {
            $d = $demandResponse->data;

            $demandFallback = (object)[
                'last_demand_id' => $d->demand_id,
                'last_demand_letter_date' => $d->demand_date,
                'last_demand_amount' => $d->amount,
                'last_amount_received' => $d->paid,
                'last_amount_received_date' => 'N/A' // API doesn't return it
            ];
        }

        return view('mis.view_property_details', compact([
            'viewDetails',
            'item',
            'separatedData',
            'demandFallback'
        ]));

    }

    //Swati Mishra for Downloading Pdf of Detailed Report 16-01-2024
    
    public function downloadPdf($property, MisService $misService)
    {
        $viewDetails = $misService->viewDetails($property);
        $item = new Item();
    
        $separatedData = self::getSeparatedPropertyTransferDetails($viewDetails->propertyTransferredLesseeDetails);
    
        // Demand fallback via API only
        $demandFallback = null;
        $fakeRequest = new Request(['property_id' => $viewDetails->old_propert_id]);
        $demandResponse = app(ReportController::class)->getDemandDetails($fakeRequest)->getData();
    
        if ($demandResponse->status) {
            $d = $demandResponse->data;
    
            $demandFallback = (object)[
                'last_demand_id' => $d->demand_id,
                'last_demand_letter_date' => $d->demand_date,
                'last_demand_amount' => $d->amount,
                'last_amount_received' => $d->paid,
                'last_amount_received_date' => 'N/A'
            ];
        }
    
        $pdfContent = view('mis.download_pdf_property_details', compact(
            'viewDetails',
            'item',
            'separatedData',
            'demandFallback' // ✅ passed to blade
        ))->render();
    
        $timestamp = date('Ymd_His');
    
        $pdf = Pdf::loadHTML($pdfContent)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans');
    
        return $pdf->download("property_details_{$property}_{$timestamp}.pdf");
    }


    //For deleting the property details - SOURAV CHAUHAN (11 july 2024)
    public function propertyDestroy($id)
    {
        //added transaction to delete the property details from all tables SOURAV CHAUHAN 18/July/2024
        try {
            $transactionSuccess = false;
            DB::transaction(function () use ($id, &$transactionSuccess) {
                $propertyDetails = PropertyMaster::find($id);
                if ($propertyDetails) {
                    $propertyMasterHistory = PropertyMasterHistory::where('property_master_id', $id)->delete();

                    $propertyLeaseDetail = PropertyLeaseDetail::where('property_master_id', $id)->delete();
                    $propertyLeaseDetailHistory = PropertyLeaseDetailHistory::where('property_master_id', $id)->delete();

                    $splitedPropertyDetail = SplitedPropertyDetail::where('property_master_id', $id)->get();
                    foreach ($splitedPropertyDetail as $splitedProperty) {
                        SplitedPropertyDetailHistory::where('splited_property_detail_id', $splitedProperty->id)->delete();
                        $splitedProperty->delete();

                    }


                    $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('property_master_id', '=', $id)->withTrashed()->forceDelete(); //uncomment when soft delete implemented
                    // $propertyTransferredLesseeDetail = PropertyTransferredLesseeDetail::where('property_master_id', '=', $id)->delete();
                    $propertyTransferLesseeDetailHistory = PropertyTransferLesseeDetailHistory::where('property_master_id', $id)->delete();

                    $currentLesseeDetail = CurrentLesseeDetail::where('property_master_id', $id)->delete();

                    $propertyInspectionDemandDetail = PropertyInspectionDemandDetail::where('property_master_id', $id)->delete();
                    $propInspDemandDetailHistory = PropInspDemandDetailHistory::where('property_master_id', $id)->delete();

                    $propertyMiscDetail = PropertyMiscDetail::where('property_master_id', $id)->delete();
                    $propertyMiscDetailHistory = PropertyMiscDetailHistory::where('property_master_id', $id)->delete();

                    $propertyContactDetail = PropertyContactDetail::where('property_master_id', $id)->delete();
                    $propertyContactDetailsHistory = PropertyContactDetailsHistory::where('property_master_id', $id)->delete();

                    $propertyDetails->delete();
                    $transactionSuccess = true;
                } else {
                    return redirect()->back()->with('failure', 'Property not found.');
                }
            });

            if ($transactionSuccess) {
                return redirect()->back()->with('success', 'Property details deleted successfully.');
            } else {
                Log::info("transaction failed");
                return redirect()->back()->with('failure', 'Property details not deleted.');
            }
        } catch (\Exception $e) {
            Log::info($e);
            return $e->getMessage();
        }
    }
}