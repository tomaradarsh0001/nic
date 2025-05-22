<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Services\ColonyService;
use App\Services\MisService;
use Illuminate\Http\Request;
use App\Models\OldColony;
use App\Models\UserProperty;
use App\Models\TempDeedOfApartment;
use App\Models\User;
use App\Models\Item;
use App\Models\Payment;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertyMaster;
use App\Models\SplitedPropertyDetail;
use App\Models\TempDocument;
use App\Models\TempSubstitutionMutation;
use App\Models\TempCoapplicant;
use App\Models\TempDocumentKey;
use Carbon\Carbon;
use App\Services\LandRateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\MutationApplication;
use App\Models\Application;
use App\Models\ApplicationAppointmentLink;
use App\Models\ApplicationMovement;
use App\Models\Coapplicant;
use App\Models\ConversionApplication;
use App\Models\DeedOfApartmentApplication;
use App\Models\Document;
use App\Models\DocumentKey;
use App\Models\Flat;
use App\Models\LandUseChangeApplication;
use App\Models\NocApplication;
use App\Models\TempLandUseChangeApplication;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\TempNoc;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    // for checking is any application available for this property id - SOURAV CHAUHAN (7/oct/2024)
    public function isPropertyFree(Request $request)
    {
        $modelsToCheck = [MutationApplication::class, TempSubstitutionMutation::class, TempDeedOfApartment::class, DeedOfApartmentApplication::class, LandUseChangeApplication::class, TempLandUseChangeApplication::class];

        // foreach ($modelsToCheck as $model) {
        //     $isPropertyIdAvailable = $model::where('old_property_id', $request->propertyId)->first();
        //     if ($isPropertyIdAvailable && optional(Item::find($isPropertyIdAvailable->status))->item_code !== 'APP_WD') {
        //         return response()->json(['status' => false, 'message' => 'Application already available for the selected Property ID:- ' . $request->propertyId]);
        //     }
        // }
        return response()->json(['status' => true, 'message' => 'Property ID:- ' . $request->propertyId . ' is available']);
    }


    public function deedOfApartmentCreateForm(ColonyService $colonyService, MisService $misService)
    {
        $colonyList = $colonyService->getColonyList();
        $propertyTypes = $misService->getItemsByGroupId(1052);
        return view('apartment.create', compact(['colonyList', 'propertyTypes']));
    }

    //Commented on 10/01/2024 By Lalit for Newly common functionality
    /*public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'applicantName' => 'required|string|max:255',
            'applicantAddress' => 'required|string',
            'buildingName' => 'required|string|max:255',
            'locality' => 'required|numeric',
            'block' => 'required|numeric',
            'plot' => 'required|numeric',
            'knownas' => 'required|string|max:255',
            'originalBuyerName' => 'required|string|max:255',
            'presentOccupantName' => 'required|string|max:255',
            'purchasedFrom' => 'required|string|max:255',
            'plotArea' => 'required|numeric',
            'flatArea' => 'required|numeric',
            'flatNumber' => 'required|string|max:255',
            'builderName' => 'required|string|max:255',
            'builderAgreementDoc' => 'required|file|mimes:pdf|max:51200', // Max 50MB
            'saleDeedDoc' => 'required|file|mimes:pdf|max:5120', // Max 5MB
            'otherDoc' => 'required|file|mimes:pdf|max:5120', // Max 5MB
            'buildingPlanDoc' => 'required|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        //Generate unique application number for that need to pass table_name & prefeix to generate applicaiton number
        $applicationNumber = GeneralFunctions::generateUniqueApplicationNumber(TempDeedOfApartment::class, 'application_number');

        // Handle file uploads
        if ($request->locality) {
            $colony = OldColony::find($request->locality);
            $colonyCode = $colony->code;
            if (isset($request->builderAgreementDoc)) {
                $builderAgreementDoc = GeneralFunctions::uploadFile($request->builderAgreementDoc, $colonyCode . '/' . $applicationNumber, 'builderAgreement');
            }
            if (isset($request->saleDeedDoc)) {
                $saleDeedDoc = GeneralFunctions::uploadFile($request->saleDeedDoc, $colonyCode . '/' . $applicationNumber, 'saleDeed');
            }
            if (isset($request->otherDoc)) {
                $otherDoc = GeneralFunctions::uploadFile($request->otherDoc, $colonyCode . '/' . $applicationNumber, 'otherDocument');
            }
            if (isset($request->buildingPlanDoc)) {
                $buildingPlanDoc = GeneralFunctions::uploadFile($request->buildingPlanDoc, $colonyCode . '/' . $applicationNumber, 'buildingPlan');
            }
        }

        // Save to database
        TempDeedOfApartment::create([
            'user_id'   => Auth::id(),
            'application_number'  => !empty($applicationNumber) ? $applicationNumber : '',
            'application_type'  => !empty(getServiceType('APP_DOA')) ? getServiceType('APP_DOA') : '',
            'applicant_name' => !empty($request->applicantName) ? $request->applicantName : '',
            'applicant_address' => !empty($request->applicantAddress) ? $request->applicantAddress : '',
            'building_name' => !empty($request->buildingName) ? $request->buildingName : '',
            'locality' => !empty($request->locality) ? $request->locality : '',
            'block' => !empty($request->block) ? $request->block : '',
            'plot' => !empty($request->plot) ? $request->plot : '',
            'known_as' => !empty($request->knownas) ? $request->knownas : '',
            'original_buyer_name' => !empty($request->originalBuyerName) ? $request->originalBuyerName : '',
            'present_occupant_name' => !empty($request->presentOccupantName) ? $request->presentOccupantName : '',
            'purchased_from' => !empty($request->purchasedFrom) ? $request->purchasedFrom : '',
            'plot_area' => !empty($request->plotArea) ? $request->plotArea : 0.00,
            'flat_id' => !empty($request->flatId) ? $request->flatId : null,
            'flat_number' => !empty($request->flatNumber) ? $request->flatNumber : '',
            'builder_developer_name' => !empty($request->builderName) ? $request->builderName : '',
            'flat_area' => !empty($request->apartmentArea) ? $request->apartmentArea : 0.00,
            'builder_agreement_doc' => !empty($builderAgreementDoc) ? $builderAgreementDoc : '',
            'sale_deed_doc' => !empty($saleDeedDoc) ? $saleDeedDoc : '',
            'other_doc' => !empty($otherDoc) ? $otherDoc : '',
            'building_plan_doc' => !empty($buildingPlanDoc) ? $buildingPlanDoc : '',
        ]);

        return redirect()->back()->with('success', 'Application successfully accepted for Deed Of Apartment.');
    }*/

    public function getProperty(Request $request)
    {
        try {
            // Initialize variables with default empty values
            $id = $oldPropertyId = $uniquePropertyId = $splittedPropertyId = '';
            // Validate request inputs
            if (!empty($request->locality) && !empty($request->block) && !empty($request->plot)) {
                // Fetch property details based on locality, block, and plot
                $property = PropertyMaster::where('new_colony_name', $request->locality)
                    ->where('block_no', $request->block)
                    ->where('plot_or_property_no', $request->plot)
                    ->first();

                // Check if the property exists
                if ($property) {
                    // Assign values to variables
                    $id = $property->id;
                    $oldPropertyId = $property->old_propert_id;
                    $uniquePropertyId = $property->unique_propert_id;
                } else {
                    // Handle split property details
                    $getSplittedDetails = SplitedPropertyDetail::where('plot_flat_no', $request->plot)
                        ->where('presently_known_as', $request->knownas)
                        ->first();

                    if ($getSplittedDetails) {
                        $property = PropertyMaster::where('new_colony_name', $request->locality)
                            ->where('block_no', $request->block)
                            ->where('id', $getSplittedDetails->property_master_id)
                            ->first();

                        if ($property) {
                            $id = $property->id;
                            $oldPropertyId = $getSplittedDetails->old_property_id;
                            $uniquePropertyId = $property->unique_propert_id;
                            $splittedPropertyId = $getSplittedDetails->id;
                        }
                    }
                }

                if ($id) {
                    return [
                        'property_master_id'    => $id,
                        'old_propert_id'        => $oldPropertyId,
                        'new_property_id'       => $uniquePropertyId,
                        'splited_property_detail_id'    => $splittedPropertyId,
                    ];
                } else {
                    // Return custom error when no record is found
                    return response()->json(['error' => 'Property details not found.'], 404);
                }
            } else {
                return response()->json(['error' => 'Invalid input. Please provide valid locality, block, and plot details.'], 400);
            }
        } catch (\Exception $e) {
            // Return custom error for exception
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $transactionSuccess = false;
            $tempDOA = null;
            $oldPropertyId = $newPropertyId = $masterPropertyId = $splittedPropertyId = '';
            if ($request->isFlatNotInList) {
                $getPropertyDataObj = self::getProperty($request);
                $oldPropertyId = $getPropertyDataObj['old_propert_id'];
                $newPropertyId = $getPropertyDataObj['new_property_id'];
                $masterPropertyId = $getPropertyDataObj['property_master_id'];
                $splittedPropertyId = $getPropertyDataObj['splited_property_detail_id'];
            } else {
                if ($request->oldPropertyId) {
                    $oldPropertyId = $request->oldPropertyId;
                }
                if ($request->newPropertyId) {
                    $newPropertyId = $request->newPropertyId;
                }
                if ($request->propertyMasterId) {
                    $masterPropertyId = $request->propertyMasterId;
                }
                if ($request->splittedPropertyId) {
                    $splittedPropertyId = $request->splittedPropertyId;
                }
            }
            $updateId = $request->updateId;
            if ($request->propertyStatus == 'Free Hold') {
                $propertyStatus = 952;
            } else {
                $propertyStatus = 951;
            }
            if ($updateId != '0') {
                DB::transaction(function () use ($request, &$transactionSuccess, &$updateId, &$tempDOA, &$propertyStatus) {
                    $tempDOA = TempDeedOfApartment::find($updateId);
                    if (isset($tempDOA)) {
                        $tempDOA->property_status = !empty($propertyStatus) ? $propertyStatus : $tempDOA->property_status;
                        $tempDOA->status_of_applicant = !empty($request->statusofapplicant) ? $request->statusofapplicant : $tempDOA->status_of_applicant;
                        $tempDOA->applicant_name = !empty($request->applicantName) ? $request->applicantName : $tempDOA->applicant_name;
                        $tempDOA->applicant_address = !empty($request->applicantAddress) ? $request->applicantAddress : $tempDOA->applicant_address;
                        $tempDOA->building_name = !empty($request->buildingName) ? $request->buildingName : $tempDOA->building_name;
                        $tempDOA->locality = !empty($request->locality) ? $request->locality : $tempDOA->locality;
                        $tempDOA->block = !empty($request->block) ? $request->block : $tempDOA->block;
                        $tempDOA->plot = !empty($request->plot) ? $request->plot : $tempDOA->plot;
                        $tempDOA->known_as = !empty($request->knownas) ? $request->knownas : $tempDOA->known_as;
                        $tempDOA->flat_id = !empty($request->flatId) ? $request->flatId : $tempDOA->flat_id;
                        $tempDOA->flat_number = !empty($request->flatNumber) ? $request->flatNumber : $tempDOA->flat_number;
                        $tempDOA->builder_developer_name = !empty($request->builderName) ? $request->builderName : $tempDOA->builder_developer_name;
                        $tempDOA->original_buyer_name = !empty($request->originalBuyerName) ? $request->originalBuyerName : $tempDOA->original_buyer_name;
                        $tempDOA->present_occupant_name = !empty($request->presentOccupantName) ? $request->presentOccupantName : $tempDOA->present_occupant_name;
                        $tempDOA->purchased_from = !empty($request->purchasedFrom) ? $request->purchasedFrom : $tempDOA->purchased_from;
                        $tempDOA->purchased_date = !empty($request->purchaseDate) ? $request->purchaseDate : $tempDOA->purchased_date;
                        $tempDOA->flat_area = !empty($request->flatArea) ? $request->flatArea : $tempDOA->flat_area;
                        $tempDOA->plot_area = !empty($request->plotArea) ? $request->plotArea : $tempDOA->plot_area;
                        $tempDOA->updated_by = Auth::user()->id;
                        if ($tempDOA->save()) {
                            $transactionSuccess = true;
                        }
                    }
                });
            } else {
                $propertyDetails = PropertyMaster::where('old_propert_id', $request->propertyid)->first();
                DB::transaction(function () use ($request, &$transactionSuccess, &$propertyDetails, &$tempDOA, &$propertyStatus, &$oldPropertyId, &$newPropertyId, &$masterPropertyId, &$splittedPropertyId) {
                    $tempDOA = TempDeedOfApartment::create([
                        'old_property_id'   => !empty($oldPropertyId) ? $oldPropertyId : $request->propertyid,
                        'new_property_id'   => !empty($newPropertyId) ? $newPropertyId : $propertyDetails['unique_propert_id'],
                        'property_master_id'   => !empty($masterPropertyId) ? $masterPropertyId : $propertyDetails['id'],
                        'splited_property_detail_id'   => !empty($splittedPropertyId) ? $splittedPropertyId : null,
                        'property_status'   => !empty($propertyStatus) ? $propertyStatus : null,
                        'status_of_applicant'   => !empty($request->statusofapplicant) ? $request->statusofapplicant : null,
                        'service_type'   => !empty(getServiceType('DOA')) ? getServiceType('DOA') : null,
                        'applicant_name'   => !empty($request->applicantName) ? $request->applicantName : null,
                        'applicant_address'   => !empty($request->applicantAddress) ? $request->applicantAddress : null,
                        'building_name'   => !empty($request->buildingName) ? $request->buildingName : null,
                        'locality'   => !empty($request->locality) ? $request->locality : null,
                        'block'   => !empty($request->block) ? $request->block : null,
                        'plot'   => !empty($request->plot) ? $request->plot : null,
                        'known_as'   => !empty($request->knownas) ? $request->knownas : null,
                        'flat_id'   => !empty($request->flatId) ? $request->flatId : null,
                        'flat_number'   => !empty($request->flatNumber) ? $request->flatNumber : null,
                        'builder_developer_name'   => !empty($request->builderName) ? $request->builderName : null,
                        'original_buyer_name'   => !empty($request->originalBuyerName) ? $request->originalBuyerName : null,
                        'present_occupant_name'   => !empty($request->presentOccupantName) ? $request->presentOccupantName : null,
                        'purchased_from'   => !empty($request->purchasedFrom) ? $request->purchasedFrom : null,
                        'purchased_date'   => !empty($request->purchaseDate) ? $request->purchaseDate : null,
                        'flat_area'   => !empty($request->flatArea) ? $request->flatArea : null,
                        'plot_area'   => !empty($request->plotArea) ? $request->plotArea : null,
                        'created_by'   => Auth::id(),
                        'updated_by'   => Auth::id(),
                    ]);
                    if ($tempDOA) {
                        $transactionSuccess = true;
                    }
                });
            }

            if ($transactionSuccess) {
                $response = ['status' => true, 'message' => 'Deed of Apartment Details Saved Successfully', 'data' => $tempDOA];
            } else {
                $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
            }
            return json_encode($response);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $response = ['status' => false, 'message' => $e->getMessage(), 'data' => 0];
            return json_encode($response);
        }
    }

    /*public function store(Request $request)
    {
        $oldPropertyId = $newPropertyId = $masterPropertyId = $splittedPropertyId = '';
        // Check if the checkbox is checked
        //Check if flat not in list then we need to get oldPropertyId,newPropertyId,masterPropertyId,splittedPropertyId through locality,block,plot & property known as
        if ($request->isFlatNotInList) {
            $getPropertyDataObj = self::getProperty($request);
            $oldPropertyId = $getPropertyDataObj['old_propert_id'];
            $newPropertyId = $getPropertyDataObj['new_property_id'];
            $masterPropertyId = $getPropertyDataObj['property_master_id'];
            $splittedPropertyId = $getPropertyDataObj['splited_property_detail_id'];
        } else {
            if ($request->old_property_id) {
                $oldPropertyId = $request->old_property_id;
            }
            if ($request->new_property_id) {
                $newPropertyId = $request->new_property_id;
            }
            if ($request->property_master_id) {
                $masterPropertyId = $request->property_master_id;
            }
            if ($request->splited_property_detail_id) {
                $splittedPropertyId = $request->splited_property_detail_id;
            }
        }

        $tempDeed = TempDeedOfApartment::create([
            'old_property_id'   => !empty($oldPropertyId) ? $oldPropertyId : null,
            'new_property_id'   => !empty($newPropertyId) ? $newPropertyId : null,
            'property_master_id'   => !empty($masterPropertyId) ? $masterPropertyId : null,
            'splited_property_detail_id'   => !empty($splittedPropertyId) ? $splittedPropertyId : null,
            'property_status'   => !empty($request->property_status) ? $request->property_status : null,
            'status_of_applicant'   => !empty($request->status_of_applicant) ? $request->status_of_applicant : null,
            'service_type'   => !empty(getServiceType('DOA')) ? getServiceType('DOA') : null,
            'applicant_name'   => !empty($request->applicantName) ? $request->applicantName : null,
            'applicant_address'   => !empty($request->applicantAddress) ? $request->applicantAddress : null,
            'building_name'   => !empty($request->buildingName) ? $request->buildingName : null,
            'locality'   => !empty($request->locality) ? $request->locality : null,
            'block'   => !empty($request->block) ? $request->block : null,
            'plot'   => !empty($request->plot) ? $request->plot : null,
            'known_as'   => !empty($request->knownas) ? $request->knownas : null,
            'flat_id'   => !empty($request->flatId) ? $request->flatId : null,
            'flat_number'   => !empty($request->flatNumber) ? $request->flatNumber : null,
            'builder_developer_name'   => !empty($request->builderName) ? $request->builderName : null,
            'original_buyer_name'   => !empty($request->originalBuyerName) ? $request->originalBuyerName : null,
            'present_occupant_name'   => !empty($request->presentOccupantName) ? $request->presentOccupantName : null,
            'purchased_from'   => !empty($request->purchasedFrom) ? $request->purchasedFrom : null,
            'purchased_date'   => !empty($request->purchaseDate) ? $request->purchaseDate : null,
            'flat_area'   => !empty($request->flatArea) ? $request->flatArea : null,
            'plot_area'   => !empty($request->plotArea) ? $request->plotArea : null,
            'created_by'   => Auth::id(),
            'updated_by'   => Auth::id(),
        ]);
        if ($tempDeed->id > 0) {
            // Return success response with last inserted ID
            return response()->json([
                'success' => true,
                'last_inserted_id' => $tempDeed->id,
                'propertyid' => $oldPropertyId,
            ]);
        }
    }*/


    //for showing application form - Sourav Chauhan - 12/sep/2024
    //Comment given below newApplication function by - Lalit Tiwari - 11/Nov/2024 for Introducing Flat dropdown for property
    /*public function newApplication(ColonyService $colonyService, MisService $misService)
    {
        // $data['userProperties'] = UserProperty::where('user_id', Auth::id())->pluck('old_property_id');
        $userProperties = UserProperty::where('user_id', Auth::id())->get();
        $fillId = [];
        foreach ($userProperties as $property) {
            $locality = OldColony::find($property->locality);
            $fillId[$property->old_property_id] = $property->block . '/' . $property->plot . '/' . $locality['name'];
        }
        $data['userProperties'] = $fillId;
        $lcm = new LandRateService();
        $data['applicantTypes'] = $lcm->getApplicantTyps();
        $data['colonyList'] = $colonyService->getColonyList();
        $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
        $data['applicantStatus'] = $misService->getItemsByGroupId(1002);
        $data['documentTypes'] = getItemsByGroupId(17005);
        return view('applicant.new_application', $data);
    }*/

    public function newApplication(ColonyService $colonyService, MisService $misService)
    {
        $userDetails = User::with('applicantUserDetails')->where('id', Auth::id())->first();
        $userProperties = UserProperty::with('flat')->where('user_id', Auth::id())->get();
        $fillId = [];

        foreach ($userProperties as $property) {
            $locality = OldColony::find($property->locality);

            // Construct the property description
            $description = $property->block . '/' . $property->plot . '/' . $locality['name'];

            // If property_id is not already set, initialize with an array
            if (!isset($fillId[$property->old_property_id])) {
                $fillId[$property->old_property_id] = [
                    'description' => $description,
                    'flats' => []
                ];
            }

            // Add flat details to the list if flat_id is not null
            if (!empty($property->flat_id) && $property->flat) {
                $fillId[$property->old_property_id]['flats'][] = [
                    'id' => $property->flat->id,
                    'flat_number' => $property->flat->flat_number
                ];
            }
        }

        $data['userProperties'] = $fillId;
        $lcm = new LandRateService();
        $data['applicantTypes'] = $lcm->getApplicantTyps();
        // $data['colonyList'] = $colonyService->getColonyList();
        $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
        // $data['applicantStatus'] = $misService->getItemsByGroupId(1002);
        $data['documentTypes'] = getItemsByGroupId(17005);
        $data['userDetails'] = $userDetails;

        return view('applicant.new_application', $data);
    }


    //for fetching property detals by property id - Sourav Chauhan - 12/sep/2024
    public function getPropertyDetails(Request $request)
    {
        $oldPropertyId = $request->propertyId;
        $updateId = $request->updateId;
        $draftApplicationPropertyId = $request->draftApplicationPropertyId;

        //for edit case
        if ($draftApplicationPropertyId == 'true') {
            $decodedModel = $request->model;

            $model = '\\App\\Models\\' . $decodedModel;
            if (!class_exists($model)) {
                return redirect()->back();
            }
            $instance = new $model();
            $serviceType = $instance->serviceType;
            //Get status of applicant dropdown value for self application - Lalit Tiwari (01/April/2025)
            // Dynamically use the model variable instead of hardcoded "Model name like TempNoc" - Lalit Tiwari (01/April/2025)
            $statusOfApplicant = $model::where('id', $updateId)->value('status_of_applicant');
            //Comment After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025) 
            // $statusOfApplicantCode = Item::where('id', $statusOfApplicant)->first();
        }

        //$data['applicationTypeOption'] = "<option value='$serviceType->item_code'>$serviceType->item_name</option>";

        // dd($draftApplicationPropertyId,$updateId);
        if ($draftApplicationPropertyId == 'false' && $updateId != 0) {
            $response = ['status' => false, 'message' => 'Data should be deleted', 'data' => 'deleteYes'];
        } else {
            $propertyDetails = PropertyMaster::where('old_propert_id', $oldPropertyId)->first();
            $data = [];
            $data['propertyDetails'] = Self::getPropertyCommonDetails($oldPropertyId);
            $data['items'] = [];
            $data['statusOfApplicationsItems'] = [];
            $inFavourCon = [];
            $transferDate = '';
            if ($propertyDetails) {
                $data['status'] = $propertyDetails['status'];
                if ($data['status'] == '952') {
                    //if free hold
                    // dd($propertyDetails);
                    $conversionDetails = PropertyTransferredLesseeDetail::where('property_master_id', $propertyDetails['id'])->where('process_of_transfer', 'Conversion')->get();
                    foreach ($conversionDetails as $conversionDetail) {
                        $name = $conversionDetail->lessee_name;
                        $transferDate = $conversionDetail->transferDate;
                        $inFavourCon[] = $name;
                    }

                    // process_of_transfer
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceType->item_code];
                        //Comment After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                        // $statusOfApplicationsCodes = [$statusOfApplicantCode->item_code];
                    } else {
                        $itemCodes = ['NOC', 'SUB_MUT', 'PRP_CERT'];
                        //Comment After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                        // $statusOfApplicationsCodes = ['POA', 'OWNER'];
                    }
                    //Add After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                    $statusOfApplicationsCodes = ['POA', 'OWNER'];
                } else {
                    //if lease hold
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceType->item_code];
                        //Comment After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                        // $statusOfApplicationsCodes = [$statusOfApplicantCode->item_code];
                    } else {
                        //Check if property related to flatid then only DOA application type should be populated - Lalit Tiwari on 11/Nov/2024
                        $userProperty = UserProperty::where('old_property_id', $oldPropertyId)->where('user_id', Auth::id())->first();
                        if (!empty($userProperty->flat_id)) {
                            $itemCodes = ['DOA'];
                        } else {
                            $itemCodes = ['LUC', 'CONVERSION', 'SEL_PERM', 'PRP_CERT', 'SUB_MUT'];
                        }
                        //Comment After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                        // $statusOfApplicationsCodes = ['POA', 'LESSEE'];
                    }
                    //Add After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                    $statusOfApplicationsCodes = ['POA', 'LESSEE'];
                }

                $data['inFavourCon'] = implode(', ', $inFavourCon);
                $data['transferDate'] = $transferDate;
                $items = Item::whereIn('item_code', $itemCodes)->where('is_active', 1)->pluck('item_name', 'item_code');
                if ($items) {
                    $data['items'] = $items;
                }
                //Add After discussing with Amita Mam. In Draft all options should be displayed for status of applicant - Lalit Tiwari (08/April/2025)
                $data['statusOfApplicant'] = $statusOfApplicant ?? '';
                //Get Status of Applications - Lalit tiwari (28/march/2025)
                $statusOfApplicationsItems = Item::whereIn('item_code', $statusOfApplicationsCodes)->pluck('item_name', 'id');
                if ($items) {
                    $data['statusOfApplicationsItems'] = $statusOfApplicationsItems;
                }
                $response = ['status' => true, 'message' => 'Provided Property is available.', 'data' => $data];
            } else {
                $response = ['status' => false, 'message' => 'Provided Property ID is not available.', 'data' => NULL];
            }
        }
        return $response;
    }

    //for fetching property detals by property id - Lalit tiwari - 04/dec/2024
    public function getPropertyDetailsForEdit(Request $request)
    {
        $oldPropertyId = $request->propertyId;
        $updateId = $request->updateId;
        $draftApplicationPropertyId = $request->draftApplicationPropertyId;

        //for edit case
        if ($draftApplicationPropertyId == 'true') {
            $decodedModel = $request->model;

            $model = '\\App\\Models\\' . $decodedModel;
            if (!class_exists($model)) {
                return redirect()->back();
            }
            $instance = new $model();
            $serviceType = $instance->serviceType;
            $serviceTypeEdit = $serviceType;
        }

        //$data['applicationTypeOption'] = "<option value='$serviceType->item_code'>$serviceType->item_name</option>";

        // dd($draftApplicationPropertyId,$updateId);
        if ($draftApplicationPropertyId == 'false' && $updateId != 0) {
            $response = ['status' => false, 'message' => 'Data should be deleted', 'data' => 'deleteYes'];
        } else {
            $propertyDetails = PropertyMaster::where('old_propert_id', $oldPropertyId)->first();
            $data = [];
            $data['propertyDetails'] = Self::getPropertyCommonDetails($oldPropertyId);
            $data['items'] = [];
            if ($propertyDetails) {
                $data['status'] = $propertyDetails['status'];
                if ($data['status'] == '952') {
                    //if free hold
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceTypeEdit->item_code];
                    } else {
                        $itemCodes = ['NOC', 'SUB_MUT', 'PRP_CERT'];
                    }
                } else {
                    //if lease hold
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceTypeEdit->item_code];
                    } else {
                        //Check if property related to flatid then only DOA application type should be populated - Lalit Tiwari on 11/Nov/2024
                        $userProperty = UserProperty::where('old_property_id', $oldPropertyId)->where('user_id', Auth::id())->first();
                        if (!empty($userProperty->flat_id)) {
                            $itemCodes = ['DOA'];
                        } else {
                            $itemCodes = ['LUC', 'CONVERSION', 'SEL_PERM', 'PRP_CERT', 'SUB_MUT'];
                        }
                        // $itemCodes = ['LUC', 'DOA', 'CONVERSION', 'SEL_PERM', 'PRP_CERT', 'SUB_MUT'];
                    }
                }
                $items = Item::whereIn('item_code', $itemCodes)->where('is_active', 1)->pluck('item_name', 'item_code');
                if ($items) {
                    $data['items'] = $items;
                }
                $response = ['status' => true, 'message' => 'Provided Property is available.', 'data' => $data];
            } else {
                $response = ['status' => false, 'message' => 'Provided Property ID is not available.', 'data' => NULL];
            }
        }
        return $response;
    }

    //for getting property common details - SOURAV CHAUHAN (10/Oct/2024)
    public function getPropertyCommonDetails($propertyId)
    {
        $propertyMaster = PropertyMaster::where('old_propert_id', $propertyId)->latest('created_at')->first();

        $data['propertyType'] = getServiceNameById($propertyMaster->property_type);
        $data['propertySubType'] = getServiceNameById($propertyMaster->property_sub_type);

        $propertyLeaseDetail = $propertyMaster->propertyLeaseDetail;
        $data['leaseType'] = getServiceNameById($propertyLeaseDetail->type_of_lease);
        $data['status'] = $propertyMaster->statusName; // added by Nitin because we need to show property status in application view page
        $data['leaseExectionDate'] = $propertyLeaseDetail->doe;
        $data['area'] = $propertyLeaseDetail->plot_area_in_sqm;
        $data['presentlyKnownAs'] = $propertyLeaseDetail->presently_known_as;

        $propertyTransferDetaails = $propertyMaster->propertyTransferredLesseeDetails;
        $originalLessee = $propertyTransferDetaails->where('process_of_transfer', 'Original')->first();
        $data['inFavourOf'] = $originalLessee->lessee_name;
        return $data;
    }

    // for fetching user details - Sourav Chauhan - 13/sep/2024
    public function fetchUserDetails()
    {
        $data = [];
        $data['user'] = $user = User::where('id', Auth::id())->first();
        $data['details'] = $user->applicantUserDetails;
        if ($data) {
            $response = ['status' => true, 'message' => 'User is available.', 'data' => $data];
        } else {
            $response = ['status' => false, 'message' => 'User is not available.', 'data' => NULL];
        }
        return $response;
    }

    public function uploadFile(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);
        //initialize variables
        // $dateOfAttestation = $attestedBy = $nameOfDeceased = $dateOfDeath = $dateOfIssue = $documentCertificateNo = $registrationNo = $volume = $bookNo = $pageFromTo = $regnDate = $regnOfficeName = $nameOfTestator = $dateOfWillCodicil = $dateOfExecution = $nameOfCourt = $dateOfCourtOrder = $certificateNo = $nameOfLessee = $nameOfNewspaperEnglish = $nameOfNewspaperHindi = $dateOfPublicNotice = $nameOfExecutor = $otherDetails = null;

        $file = $request->file;
        $name = $request->name;
        $docType = $request->docType;
        $type = $request->type;
        $propertyId = $request->propertyId;
        $updateId = $request->updateId;
        $processType = $request->processType;
        // dd($file,$name,$docType,$type,$propertyId,$updateId,$processType,$request->isResubmmit);

        $user = Auth::user();
        $userDetails = $user->applicantUserDetails;
        $registrationNumber = $userDetails->applicant_number;
        $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
        $colonyId = $propertyDetails['new_colony_name'];
        $colony = OldColony::find($colonyId);
        $colonyCode = $colony->code;

        if ($file) {
            $service_type = getServiceType($processType);
            if ($type == 'mutation') {
                $processType = strtoupper($type);
            }
            $modelName = config('applicationDocumentType.' . $processType . '.TempModelName');
            if (isset($request->isResubmmit)) {
                $documentUploded = false;
            } else {
                $documentUploded = TempDocument::where('service_type', $service_type)->where('model_id', $updateId)->where('document_type', $docType)->first();
            }
            $date = now()->format('YmdHis');
            $fileName = $docType . '_' . $date . '.' . $file->extension();
            $pathToUpload = $registrationNumber . '/' . $colonyCode . '/' . $type . '/' . $updateId;
            if ($documentUploded) {
                //delete the fie from folder
                $deletedFile = $documentUploded->file_path;
                if ($deletedFile) {
                    if (Storage::disk('public')->exists($deletedFile)) {
                        Storage::disk('public')->delete($deletedFile);
                    }
                    $path = $file->storeAs($pathToUpload, $fileName, 'public');
                    if ($path) {
                        $documentUploded->file_path = $path;
                        $documentUploded->updated_by = Auth::user()->id;

                        if ($documentUploded->save()) {
                            return response()->json(['status' => true, 'path' => $path]);
                        } else {
                            return response()->json(['status' => false, 'message' => 'File update failed.']);
                        }
                    }
                }
            } else {
                $path = $file->storeAs($pathToUpload, $fileName, 'public');
                if ($path) {
                    if ($request->isResubmmit) {
                        $documentUploded = Document::create([
                            'service_type' => $service_type,
                            'model_name' => 'MutationApplication', //'TempSubstitutionMutation',
                            'model_id' => $updateId,
                            'title' => $name,
                            'document_type' => $docType,
                            'file_path' => $path,
                            'user_id' => Auth::user()->id,
                        ]);
                    } else {
                        $documentUploded = TempDocument::create([
                            'service_type' => $service_type,
                            'model_name' => $modelName, //'TempSubstitutionMutation',
                            'model_id' => $updateId,
                            'title' => $name,
                            'document_type' => $docType,
                            'file_path' => $path,
                            'created_by' => Auth::user()->id,
                        ]);
                    }
                    if ($documentUploded) {
                        return response()->json(['status' => true, 'path' => $path]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'File saving failed.']);
                    }
                }
            }
        }

        return response()->json(['status' => false, 'message' => 'File upload failed.']);
    }

    //Get all incomplete applications
    public function draftApplications()
    {
        return view('application.draft.index');
    }

    public function getDraftApplications(Request $request)
    {
        // Define the columns that can be ordered and searched
        $columns = [
            'id', // index 0
            'old_propert_id', // index 2
            'new_colony_name', // index 3
            'block_no', // index 4
            'plot_or_property_no', // index 5
            'flat_id', // index 6
            'presently_known_as', // index 7
            'applied_for', // index 8
            'created_at', // index 9
        ];

        // Define the first table query
        $query1 = DB::table('temp_substitution_mutation as tsm')
            ->leftJoin('property_masters', 'tsm.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('tsm.created_by', '=', Auth::id())
            ->select(
                'tsm.id',
                'tsm.created_at',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'TempSubstitutionMutation' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('tsm.created_at', 'like', "%$searchValue%");
            });
        }

        //Land use change
        $query2 = DB::table('temp_land_use_change_applications as luc') // Replace 'another_table' with your actual table name
            ->leftJoin('property_masters', 'luc.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('luc.created_by', '=', Auth::id())
            ->select(
                'luc.id', // Ensure this is compatible with the first query
                'luc.created_at',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'TempLandUseChangeApplication' as model_name") // Add model_name for the second query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query2->where(function ($query) use ($searchValue) {
                $query->where('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('luc.created_at', 'like', "%$searchValue%");
            });
        }

        //Deed Of Apartment
        $query3 = DB::table('temp_deed_of_apartments as doa') // Replace 'another_table' with your actual table name
            ->leftJoin('property_masters', 'doa.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoin('flats', 'doa.flat_id', '=', 'flats.id')
            ->where('doa.created_by', '=', Auth::id())
            ->select(
                'doa.id', // Ensure this is compatible with the first query
                'doa.created_at',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                'flats.unique_flat_id as flat_id', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                'flats.flat_number as flat_number', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw("'TempDeedOfApartment' as model_name") // Add model_name for the second query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query3->where(function ($query) use ($searchValue) {
                $query->where('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('flats.unique_flat_id', 'like', "%$searchValue%")  // Search By Flat Id
                    ->orWhere('flats.flat_number', 'like', "%$searchValue%")  // Search By Flat Number
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('doa.created_at', 'like', "%$searchValue%");
            });
        }

        // Combine all three queries using UNION
        // $combinedQuery = $query1->union($query2);
        $query4 = DB::table('temp_conversion_applications as tca')
            ->leftJoin('property_masters', 'tca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('tca.created_by', '=', Auth::id())
            ->select(
                'tca.id',
                'tca.created_at',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'TempConversionApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query4->where(function ($query) use ($searchValue) {
                $query->where('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('tca.created_at', 'like', "%$searchValue%");
            });
        }

        //Query 5 for NOC application - Lalit (18/March/2025)
        $query5 = DB::table('temp_nocs as noc')
            ->leftJoin('property_masters', 'noc.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('noc.created_by', '=', Auth::id())
            ->select(
                'noc.id',
                'noc.created_at',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'TempNoc' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('noc.created_at', 'like', "%$searchValue%");
            });
        }


        $clonedQuery1 = (clone $query1);
        $clonedQuery2 = (clone $query2);
        $clonedQuery3 = (clone $query3);
        $clonedQuery4 = (clone $query4);
        $clonedQuery5 = (clone $query5);

        // Combine all three queries using UNION
        $combinedQuery = $clonedQuery1->union($clonedQuery2)->union($clonedQuery3)->union($clonedQuery4)->union($clonedQuery5);
        // $combinedQuery = $clonedQuery1;

        $limit = $request->input('length');
        $start = $request->input('start');
        if ($request->input('order.0.column')) {
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        } else {
            $order = 'created_at';
            $dir = 'desc';
        }


        $totalData = $combinedQuery->count();
        $totalFiltered = $totalData;

        // Pagination parameters
        $limit = $request->input('length');
        $start = $request->input('start');

        // Apply ordering and limit/offset
        $applications = $combinedQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        // dd($applications);
        foreach ($applications as $key => $application) {
            $nestedData['id'] = $key + 1;
            $nestedData['old_property_id'] = $application->old_propert_id;
            $nestedData['new_colony_name'] = $application->colony_name;
            $nestedData['block_no'] = $application->block_no;
            $nestedData['plot_or_property_no'] = $application->plot_or_property_no;
            $nestedData['presently_known_as'] = $application->presently_known_as;
            $flatHTML = '';
            if (!empty($application->flat_id)) {
                $flatHTML .= '<div class="d-flex gap-2 align-items-center">' . $application->flat_number . '</div><span class="text-secondary">(' . $application->flat_id . ')</span>';
            } else {
                $flatHTML .= '<div>NA</div>';
            }
            $nestedData['flat_id'] =   $flatHTML;

            switch ($application->model_name) {
                case 'TempSubstitutionMutation':
                    $appliedFor = 'Mutation';
                    break;
                case 'TempLandUseChangeApplication':
                    $appliedFor = 'LUC';
                    break;
                case 'TempDeedOfApartment':
                    $appliedFor = 'DOA';
                    break;
                case 'TempConversionApplication':
                    $appliedFor = 'Conversion';
                    break;
                case 'TempNoc':
                    $appliedFor = 'Noc';
                    break;
                default:
                    // Default action
                    break;
            }
            $nestedData['applied_for'] = '<label class="badge bg-info mx-1">' . $appliedFor . '</label>';
            $model = base64_encode($application->model_name);

            // Prepare actions
            $action = '<a href="' . url('edharti/applications/draft/' . $application->id) . '?type=' . $model . '"><button type="button" class="btn btn-primary px-5">Complete Application</button></a> <a href="javascript:void(0)" ><button type="button" class="btn btn-danger px-5" onclick="deleteConfirmModal(\'Are you sure to delete ' . $appliedFor . ' application?\',\'' . base64_encode($application->model_name) . '\',\'' . base64_encode($application->id) . '\')">Delete Draft</button></a>';
            $nestedData['action'] = $action;
            $nestedData['created_at'] = Carbon::parse($application->created_at)
                ->setTimezone('Asia/Kolkata')
                ->format('d M Y H:i:s');

            $data[] = $nestedData;
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }

    public function getDraftApplication(Request $request, $id, ColonyService $colonyService, MisService $misService)
    {
        $decodedModel = base64_decode($request->type);
        $data['decodedModel'] = $decodedModel;
        $model = '\\App\\Models\\' . $decodedModel;
        if (!class_exists($model)) {
            return redirect()->back();
        }
        $applicationQuery = $model::where('id', $id);
        // Conditionally add the alias for 'applicant_status' while keeping all other columns
        if ($decodedModel == 'TempLandUseChangeApplication') {
            $applicationQuery = $applicationQuery->addSelect('*', 'applicant_status as status_of_applicant');
        }

        // Fetch the first result and store it in $data['application']
        $application = $applicationQuery->first();
        $data['application'] = $application;
        if (!empty($application)) {
            $data['application']['objectApplication'] = '';
            // dd($decodedModel, $id);
            $documentKeys = [];
            $tempCoapplicant = null;
            $stepSecondFinalDocuments = [];
            $stepThirdFinalDocuments = [];
            // userDetails & userProperties For Deed Of Apartment Added by Lalit Tiwari on 13/Nov/2024
            $userProperties = $userDetails = [];
            $documents = TempDocument::where('model_name', $decodedModel)
                ->where('model_id', $id)
                ->get();


            // dd($documents, $decodedModel, $id);
            $finalDocs = [];

            foreach ($documents as $key => $document) {
                // foreach ($document as $doc) {
                $values = TempDocumentKey::where('temp_document_id', $document->id)->get();
                $document->values = $values;
                // }
                $finalDocs[] = $document;
            }

            switch ($decodedModel) {
                case 'TempSubstitutionMutation':
                    $appliedFor = 'Mutation';
                    if ($documents->count() != 0) {
                        // TempDocument::where('model_name',$decodedModel)->where('model_id',)
                        // dd()

                        //second step douments ***********************************88
                        //$stepSecondFilters = config('applicationDocumentType.MUTATION.Required');
                        // $topLevelKeys = array_keys($stepSecondFilters);
                        // $topLevelIds = array_column($stepSecondFilters, 'id');
                        // $stepSecondFilteredDocuments = $documents->filter(function ($document) use ($topLevelIds) {
                        //     return in_array($document->document_type, $topLevelIds);
                        // });
                        // dd($stepSecondFilteredDocuments);
                        // foreach ($stepSecondFilteredDocuments as $document) {
                        //     // Ensure that document_type and file_path are set before using them
                        //     if (isset($document->document_type) && isset($document->file_path)) {
                        //         $stepSecondFinalDocuments[$document->document_type]['file_path'] = $document->file_path;

                        //         // Fetch TempDocumentKeys related to the current document
                        //         $tempDocumentKeys = TempDocumentKey::where('temp_document_id', $document->id)->get();

                        //         // Check if tempDocumentKeys collection is not empty
                        //         if ($tempDocumentKeys->isNotEmpty()) {
                        //             foreach ($tempDocumentKeys as $tempDocumentKey) {
                        //                 // Use the key to retrieve label and type from the config
                        //                 $label = config('applicationDocumentType.MUTATION.Required.' . $document->document_type . '.' . $tempDocumentKey->key . '.label');
                        //                 $type = config('applicationDocumentType.MUTATION.Required.' . $document->document_type . '.' . $tempDocumentKey->key . '.type');

                        //                 // Safely initialize the nested arrays
                        //                 $stepSecondFinalDocuments[$document->document_type]['value'][$tempDocumentKey->key] = [
                        //                     'value' => $tempDocumentKey->value,
                        //                     'label' => $label,
                        //                     'type' => $type,
                        //                 ];
                        //             }
                        //         }
                        //     }
                        // }
                        // dd($stepSecondFinalDocuments,$stepSecondFilters);
                        // dd($stepSecondFilters);
                        // $stepSecondFilterIds = array_column($stepSecondFilters, 'id');
                        // dd($stepSecondFilterIds);
                        // foreach ($stepSecondFilters as $documentType => $stepSecondFilter) {
                        //     // dd($stepSecondFinalDocuments[$stepSecondFilter['id']]);
                        //     // Check if the document type exists in the final documents
                        //     if (!isset($stepSecondFinalDocuments[$stepSecondFilter['id']])) {
                        //         // Initialize the document type if it doesn't exist
                        //         $stepSecondFinalDocuments[$stepSecondFilter['id']] = [
                        //             'file_path' => null, // Set file_path to null
                        //             'value' => [] // Initialize value array
                        //         ];
                        //         dd($stepSecondFilter);
                        //         // Populate the 'value' array with stepSecondFilter from $stepSecondFilters
                        //         foreach ($stepSecondFilter as $key => $field) {
                        //             $stepSecondFinalDocuments[$documentType]['value'][$key] = [
                        //                 'value' => null, // Set to null
                        //                 'label' => $field['label'],
                        //                 'type' => $field['type']
                        //             ];
                        //         }
                        //     } else {
                        //         dd($stepSecondFilter);
                        //         // If the document type exists, ensure the 'value' is populated with nulls for missing stepSecondFilter
                        //         foreach ($stepSecondFilter as $key => $field) {
                        //             dd($stepSecondFinalDocuments,$field);
                        //             if (!isset($stepSecondFinalDocuments[$documentType]['value'][$key])) {
                        //                 $stepSecondFinalDocuments[$documentType]['value'][$key] = [
                        //                     'value' => null,
                        //                     'label' => $field['label'],
                        //                     'type' => $field['type']
                        //                 ];
                        //             }
                        //         }
                        //     }
                        // }


                        //Third step douments*************************************
                        // $stepThirdFilters = config('applicationDocumentType.MUTATION.Optional');
                        // $topLevelKeys = array_keys($stepThirdFilters);
                        // $stepThirdFilteredDocuments = $documents->filter(function ($document) use ($topLevelKeys) {
                        //     return in_array($document->title, $topLevelKeys);
                        // });
                        // dd($stepThirdFilteredDocuments);
                        // foreach ($stepThirdFilteredDocuments as $document) {
                        //     $stepThirdFinalDocuments[$document->document_type]['file_path'] = $document->file_path;
                        //     $tempDocumentKeys = TempDocumentKey::where('temp_document_id', $document->id)->get();
                        //     foreach ($tempDocumentKeys as $tempDocumentKey) {
                        //         $label = config("applicationDocumentType.MUTATION.Optional." . $document->document_type . "." . $tempDocumentKey->key . ".label");
                        //         $type  = config("applicationDocumentType.MUTATION.Optional." . $document->document_type . "." . $tempDocumentKey->key . ".type");
                        //         $stepThirdFinalDocuments[$document->document_type]['value'][$tempDocumentKey->key]['value'] = $tempDocumentKey->value;
                        //         $stepThirdFinalDocuments[$document->document_type]['value'][$tempDocumentKey->key]['label'] = $label;
                        //         $stepThirdFinalDocuments[$document->document_type]['value'][$tempDocumentKey->key]['type'] = $type;
                        //     }
                        // }


                        // foreach ($stepThirdFilters as $documentType => $fields) {
                        //     // Check if the document type exists in the final documents
                        //     if (!isset($stepThirdFinalDocuments[$documentType])) {
                        //         // Initialize the document type if it doesn't exist
                        //         $stepThirdFinalDocuments[$documentType] = [
                        //             'file_path' => null, // Set file_path to null
                        //             'value' => [] // Initialize value array
                        //         ];

                        //         // Populate the 'value' array with fields from $stepSecondFilters
                        //         foreach ($fields as $key => $field) {
                        //             $stepThirdFinalDocuments[$documentType]['value'][$key] = [
                        //                 'value' => null, // Set to null
                        //                 'label' => $field['label'],
                        //                 'type' => $field['type']
                        //             ];
                        //         }
                        //     } else {
                        //         // If the document type exists, ensure the 'value' is populated with nulls for missing fields
                        //         foreach ($fields as $key => $field) {
                        //             if (!isset($stepThirdFinalDocuments[$documentType]['value'][$key])) {
                        //                 $stepThirdFinalDocuments[$documentType]['value'][$key] = [
                        //                     'value' => null,
                        //                     'label' => $field['label'],
                        //                     'type' => $field['type']
                        //                 ];
                        //             }
                        //         }
                        //     }
                        // }
                    }
                    // dd($decodedModel,$id);
                    $data['tempCoapplicant'] = TempCoapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                    // dd($data);
                    $data['documentTypes'] = getItemsByGroupId(17005);
                    break;

                //land use change
                case 'TempLandUseChangeApplication':
                    $data['appliedFor'] = 'LUC';
                    $data['applicationDocumentType'] = config('applicationDocumentType.LUC.Required');
                    if (!empty($documents)) {
                        foreach ($documents as $document) {
                            $stepSecondFinalDocuments[$document->document_type]['file_path'] = $document->file_path;
                            $tempDocumentKeys = TempDocumentKey::where('temp_document_id', $document->id)->get();
                            foreach ($tempDocumentKeys as $tempDocumentKey) {
                                $stepSecondFinalDocuments[$document->document_type]['value'][$tempDocumentKey->key] = $tempDocumentKey->value;
                            }
                        }
                    }
                    $finalDocs = $stepSecondFinalDocuments;
                    break;

                // $tempCoapplicant = TempCoapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                case 'TempDeedOfApartment':
                    $userDetails = User::with('applicantUserDetails')->where('id', Auth::id())->first();
                    $userDetails = User::with('applicantUserDetails')->where('id', Auth::id())->first();
                    //second step douments ***********************************88
                    $stepSecondFilters = config('applicationDocumentType.DOA.documents');
                    $topLevelKeys = array_keys($stepSecondFilters);
                    $stepSecondFilteredDocuments = $documents->filter(function ($document) use ($topLevelKeys) {
                        return in_array($document->title, $topLevelKeys);
                    });
                    foreach ($stepSecondFilteredDocuments as $document) {
                        $stepSecondFinalDocuments[$document->document_type]['file_path'] = $document->file_path;
                    }

                    foreach ($stepSecondFilters as $documentType => $fields) {
                        // Check if the document type exists in the final documents
                        if (!isset($stepSecondFinalDocuments[$documentType])) {
                            // Initialize the document type if it doesn't exist
                            $stepSecondFinalDocuments[$documentType] = [
                                'file_path' => null, // Set file_path to null
                            ];
                        }
                    }
                case 'TempConversionApplication':
                    if ($documents->count() != 0) {
                    }
                    $data['tempCoapplicant'] = TempCoapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                    $data['documentTypes'] = getItemsByGroupId(17005);
                    // dd($data);
                case 'TempNoc':
                    $appliedFor = 'Noc';
                    // dd($decodedModel,$id);
                    $data['tempCoapplicant'] = TempCoapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                    // dd($data);
                    $data['documentTypes'] = getItemsByGroupId(17005);
                    break;

                default:
                    // Default action
                    break;
            }
            // dd($finalDocs);
            $data['stepSecondFinalDocuments'] = $finalDocs;
            $data['stepThirdFinalDocuments'] = $stepThirdFinalDocuments;
            // $data['applicantStatus'] = $misService->getItemsByGroupId(1002);
            $data['colonyList'] = $colonyService->getColonyList();
            $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
            $data['documentTypes'] = getItemsByGroupId(17005);
            $lcm = new LandRateService();
            $data['applicantTypes'] = $lcm->getApplicantTyps();
            // $data['finalDocs'] = $lcm->getApplicantTyps();

            // userDetails & userProperties For Deed Of Apartment Added by Lalit Tiwari on 13/Nov/2024
            $data['userDetails'] = $userDetails;
            $data['userProperties'] = $userProperties;
            return view('applicant.new_application', $data);
        } else {
            return redirect()->route('draftApplications')->with('failure', 'Application not available!');
        }
    }

    public function getEditApplications(Request $request, $id, ColonyService $colonyService, MisService $misService)
    {
        $actionType = base64_decode($request->action);
        $decodedModel = base64_decode($request->type);
        if (!empty($actionType) && !empty($decodedModel)) {
            $data['decodedModel'] = $decodedModel;
            $model = '\\App\\Models\\' . $decodedModel;
            if (!class_exists($model)) {
                return redirect()->back();
            }

            $applicationQuery = $model::where('id', $id);
            // Conditionally add the alias for 'applicant_status' while keeping all other columns
            if ($decodedModel == 'LandUseChangeApplication') {
                $applicationQuery = $applicationQuery->addSelect('*', 'applicant_status as status_of_applicant');
            }

            // Fetch the first result and store it in $data['application']
            $application = $applicationQuery->first();
            if ($application->status != getServiceType('APP_OBJ')) {
                return redirect()->route('applications.history.details')->with('failure', 'Application not available for edit!');
            }
            $data['application'] = $application;
            if (!empty($application)) {
                $data['application']['objectApplication'] = 'objectApplication';

                // dd($decodedModel, $id);
                $documentKeys = [];
                $tempCoapplicant = null;
                $stepSecondFinalDocuments = [];
                $stepThirdFinalDocuments = [];
                // userDetails & userProperties For Deed Of Apartment Added by Lalit Tiwari on 13/Nov/2024
                $userProperties = $userDetails = [];
                $documents = Document::where('model_name', $decodedModel)
                    ->where('model_id', $id)
                    ->get();

                $additionalDocuments = $documents->where('document_type', 'AdditionalDocument')->whereNotNull('file_path');
                // dd($documents, $decodedModel, $id);
                //Code for Fetch Additional Documents for All applicaiton - Lalit tiwari (06/dec/2024)
                $data['additionalDocuments'] =  $additionalDocuments;

                $finalDocs = [];

                foreach ($documents as $key => $document) {
                    // foreach ($document as $doc) {
                    $values = DocumentKey::where('document_id', $document->id)->get();
                    $document->values = $values;
                    // }
                    $finalDocs[] = $document;
                }
                switch ($decodedModel) {
                    case 'MutationApplication':
                        $appliedFor = 'Mutation';
                        if ($documents->count() != 0) {
                        }
                        // dd($decodedModel,$id);
                        $data['tempCoapplicant'] = Coapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                        // dd($data);
                        $data['documentTypes'] = getItemsByGroupId(17005);
                        break;

                    //land use change
                    case 'LandUseChangeApplication':
                        // dd($documents, $stepSecondFinalDocuments);
                        $data['appliedFor'] = 'LUC';
                        $data['applicationDocumentType'] = config('applicationDocumentType.LUC.Required');
                        if (!empty($documents)) {
                            foreach ($documents as $document) {
                                $stepSecondFinalDocuments[$document->document_type]['file_path'] = $document->file_path;
                                $documentKeys = DocumentKey::where('document_id', $document->id)->get();
                                foreach ($documentKeys as $documentKey) {
                                    $stepSecondFinalDocuments[$document->document_type]['value'][$documentKey->key] = $documentKey->value;
                                }
                            }
                        }
                        $finalDocs = isset($stepSecondFinalDocuments) ? $stepSecondFinalDocuments : [];
                        // $tempCoapplicant = TempCoapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                    case 'DeedOfApartmentApplication':
                        $userDetails = User::with('applicantUserDetails')->where('id', Auth::id())->first();
                        //second step douments ***********************************88
                        $stepSecondFilters = config('applicationDocumentType.DOA.documents');
                        $topLevelKeys = array_keys($stepSecondFilters);
                        $stepSecondFilteredDocuments = $documents->filter(function ($document) use ($topLevelKeys) {
                            return in_array($document->title, $topLevelKeys);
                        });
                        foreach ($stepSecondFilteredDocuments as $document) {
                            $stepSecondFinalDocuments[$document->document_type]['file_path'] = $document->file_path;
                        }

                        foreach ($stepSecondFilters as $documentType => $fields) {
                            // Check if the document type exists in the final documents
                            if (!isset($stepSecondFinalDocuments[$documentType])) {
                                // Initialize the document type if it doesn't exist
                                $stepSecondFinalDocuments[$documentType] = [
                                    'file_path' => null, // Set file_path to null
                                ];
                            }
                        }
                    case 'ConversionApplication':
                        if ($documents->count() != 0) {
                        }
                        $data['tempCoapplicant'] = Coapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                        $data['documentTypes'] = getItemsByGroupId(17005);
                        // dd($data);
                    case 'NocApplication':
                        $data['tempCoapplicant'] = Coapplicant::where('model_name', $decodedModel)->where('model_id', $id)->get();
                        $data['documentTypes'] = getItemsByGroupId(17005);
                    default:
                        // Default action
                        break;
                }
                // dd($finalDocs);
                $data['stepSecondFinalDocuments'] = $finalDocs;
                $data['stepThirdFinalDocuments'] = $stepThirdFinalDocuments;
                $data['applicantStatus'] = $misService->getItemsByGroupId(1002);
                $data['colonyList'] = $colonyService->getColonyList();
                $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
                $data['documentTypes'] = getItemsByGroupId(17005);
                $lcm = new LandRateService();
                $data['applicantTypes'] = $lcm->getApplicantTyps();
                // $data['finalDocs'] = $lcm->getApplicantTyps();

                // userDetails & userProperties For Deed Of Apartment Added by Lalit Tiwari on 13/Nov/2024
                $data['userDetails'] = $userDetails;
                $data['userProperties'] = $userProperties;
                $data['actionType'] = $actionType;
                // @dd($data);
                return view('applicant.edit_application', $data);
            } else {
                return redirect()->route('applications.history.details')->with('failure', 'Application not available!');
            }
        }
    }


    public function applicationsHistoryDetails()
    {
        return view('application.history.index');
    }

    //for fetching the applications which are submitted successfully - - SOURAV CHAUHAN (4/oct/2024)
    // Original Before Edit Functionality , Commented on 29/Nov/2024 - Lalit Tiwari (29/Nov/2024)
    /*public function getHistoryApplications(Request $request)
    {
        // Define the columns that can be ordered and searched
        $columns = ['id', 'old_property_id'];

        // Start query
        $query2 = DB::table('land_use_change_applications as lca')
            ->leftJoin('property_masters', 'lca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('lca.created_by', '=', Auth::id())
            ->where('lca.status', '!=', getServiceType('APP_WD'))
            ->select(
                'lca.id',
                'lca.created_at',
                DB::raw('coalesce(lca.application_no,"0") as application_no'),
                'lca.status',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw("'LandUseChangeApplication' as model_name") // Add model_name for the first query
            );

        // Define the first table query
        $query1 = DB::table('mutation_applications as ma')
            ->leftJoin('property_masters', 'ma.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('ma.created_by', '=', Auth::id())
            ->where('ma.status', '!=', getServiceType('APP_WD'))
            ->select(
                'ma.id',
                'ma.created_at',
                'ma.application_no',
                'ma.status',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw("'MutationApplication' as model_name") // Add model_name for the first query
            );

        //Conversion
        $query3 = DB::table('deed_of_apartment_applications as doa')
            ->leftJoin('property_masters', 'doa.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('doa.created_by', '=', Auth::id())
            ->where('doa.status', '!=', getServiceType('APP_WD'))
            ->select(
                'doa.id',
                'doa.created_at',
                'doa.application_no',
                'doa.status',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw("'DeedOfApartmentApplication' as model_name") // Add model_name for the first query
            );

        $query4 = DB::table('conversion_applications as ca')
            ->leftJoin('property_masters', 'ca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('ca.created_by', '=', Auth::id())
            ->where('ca.status', '!=', getServiceType('APP_WD'))
            ->select(
                'ca.id',
                'ca.created_at',
                'ca.application_no',
                'ca.status',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw("'ConversionApplication' as model_name") // Add model_name for the first query
            );

        // Combine all three queries using UNION
        $combinedQuery = $query1->union($query2)->union($query3)->union($query4);

        // Execute the combined query
        // $query = $combinedQuery->get();

        // Apply search filter for global search
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $combinedQuery->where(function ($q) use ($search) {
                $q->where('old_property_id', 'like', "%{$search}%");
            });
        }

        $totalData = $combinedQuery->count();
        $totalFiltered = $totalData;

        // Pagination parameters
        $limit = $request->input('length');
        $start = $request->input('start');

        // Order by requested column
        $orderColumnIndex = $request->input('order.0.column');
        // $order = $columns[$orderColumnIndex] ?? 'id'; // Default order by 'id' if index is invalid
        // $dir = $request->input('order.0.dir');

        // Use raw SQL to sort by concatenated columns
        // $query->orderBy($order, $dir);

        // Apply ordering and limit/offset
        $applications = $combinedQuery->offset($start)
            ->limit($limit)
            ->get();
        $data = [];
        foreach ($applications as $key => $application) {
            $nestedData['id'] = $key + 1;
            $nestedData['application_no'] = $application->application_no;
            $nestedData['old_property_id'] = $application->old_propert_id;
            $nestedData['new_colony_name'] = $application->colony_name;
            $nestedData['block_no'] = $application->block_no;
            $nestedData['plot_or_property_no'] = $application->plot_or_property_no;
            $nestedData['presently_known_as'] = $application->presently_known_as;

            switch ($application->model_name) {
                case 'MutationApplication':
                    $appliedFor = 'Mutation';
                    break;
                case 'LandUseChangeApplication':
                    $appliedFor = 'LUC';
                    break;
                case 'DeedOfApartmentApplication':
                    $appliedFor = 'DOA';
                    break;
                case 'ConversionApplication':
                    $appliedFor = 'CONVERSION';
                    break;
                default:
                    // Default action
                    break;
            }
            //for getting status
            $item = getStatusDetailsById($application->status);
            $itemCode = $item->item_code;
            $itemName = $item->item_name;
            $itemColor = $item->color_code;
            $statusClasses = [
                'RS_REJ' => 'text-danger bg-light-danger',
                'APP_NEW' => 'text-primary bg-light-primary',
                'APP_WD' => 'text-warning bg-light-warning',
                'RS_REW' => 'text-white bg-secondary',
                'RS_PEN' => 'text-info bg-light-info',
                'RS_APP' => 'text-success bg-light-success',
            ];
            $class = $statusClasses[$itemCode] ?? 'text-secondary bg-light';

            $nestedData['applied_for'] = '<label class="badge bg-info mx-1">' . $appliedFor . '</label>';
            $nestedData['status'] = '<div class="badge rounded-pill ' . $class . ' p-2 text-uppercase px-3">' . ucwords($itemName) . '</div>';
            $model = base64_encode($application->model_name);

            // Prepare actions
            $action = '<button type="button" class="btn btn-danger px-5" onclick="withdrawApplication(\'' . $application->application_no . '\')">Withdraw Application</button>';
            $nestedData['action'] = $action;
            $nestedData['created_at'] = $application->created_at;

            $data[] = $nestedData;
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }*/

    // Adding Flat for Edit Applicaiton Functionality , Commented on 29/Nov/2024 - Lalit Tiwari (29/Nov/2024)
    public function getHistoryApplications(Request $request)
    {
        //getServiceType for Object status - Lalit tiwari (02/12/2024)
        $objectId = getServiceType('APP_OBJ');
        // Define the columns that can be ordered and searched
        $columns = [
            'id', // index 0
            'application_no', // index 1
            'old_propert_id', // index 2
            'new_colony_name', // index 3
            'block_no', // index 4
            'plot_or_property_no', // index 5
            'flat_id', // index 6
            'presently_known_as', // index 7
            'applied_for', // index 8
            'status', // index 9
            'remark', // index 9
            'created_at', // index 10
        ];

        $latestAppMovements = DB::table('application_movements as am1')
            ->select('am1.*')
            ->join(DB::raw('
        (
            SELECT application_no, MAX(created_at) as latest_created_at
            FROM application_movements
            WHERE action = "APP_OBJ" AND application_no IS NOT NULL
            GROUP BY application_no
        ) as am2
    '), function ($join) {
                $join->on('am1.application_no', '=', 'am2.application_no')
                    ->on('am1.created_at', '=', 'am2.latest_created_at');
            })
            ->where('am1.action', 'APP_OBJ');

        // Define the first table query
        $query1 = DB::table('mutation_applications as ma')
            ->leftJoin('property_masters', 'ma.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoinSub($latestAppMovements, 'am', function ($join) {
                $join->on('ma.application_no', '=', 'am.application_no');
            })
            ->where('ma.created_by', '=', Auth::id())
            ->where('ma.status', '!=', getServiceType('APP_WD'))
            ->select(
                'ma.id',
                'ma.created_at',
                'ma.application_no',
                'ma.status',
                'am.remarks',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'MutationApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('ma.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('ma.created_at', 'like', "%$searchValue%");
            });
        }


        // Start query
        $query2 = DB::table('land_use_change_applications as lca')
            ->leftJoin('property_masters', 'lca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoinSub($latestAppMovements, 'am', function ($join) {
                $join->on('lca.application_no', '=', 'am.application_no');
            })
            ->where('lca.created_by', '=', Auth::id())
            ->where('lca.status', '!=', getServiceType('APP_WD'))
            ->select(
                'lca.id',
                'lca.created_at',
                DB::raw('coalesce(lca.application_no,"0") as application_no'),
                'lca.status',
                'am.remarks',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'LandUseChangeApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query2->where(function ($query) use ($searchValue) {
                $query->where('lca.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('lca.created_at', 'like', "%$searchValue%");
            });
        }


        //Conversion
        $query3 = DB::table('deed_of_apartment_applications as doa')
            ->leftJoin('property_masters', 'doa.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoin('flats', 'doa.flat_id', '=', 'flats.id')
            ->leftJoinSub($latestAppMovements, 'am', function ($join) {
                $join->on('doa.application_no', '=', 'am.application_no');
            })
            ->where('doa.created_by', '=', Auth::id())
            ->where('doa.status', '!=', getServiceType('APP_WD'))
            ->select(
                'doa.id',
                'doa.created_at',
                'doa.application_no',
                'doa.status',
                'am.remarks',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                'flats.unique_flat_id as flat_id', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                'flats.flat_number as flat_number', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw("'DeedOfApartmentApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query3->where(function ($query) use ($searchValue) {
                $query->where('doa.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('flats.unique_flat_id', 'like', "%$searchValue%")  // Search By Flat Id
                    ->orWhere('flats.flat_number', 'like', "%$searchValue%")  // Search By Flat Number
                    ->orWhere('doa.created_at', 'like', "%$searchValue%");
            });
        }

        $query4 = DB::table('conversion_applications as ca')
            ->leftJoin('property_masters', 'ca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoinSub($latestAppMovements, 'am', function ($join) {
                $join->on('ca.application_no', '=', 'am.application_no');
            })
            ->where('ca.created_by', '=', Auth::id())
            ->where('ca.status', '!=', getServiceType('APP_WD'))
            ->select(
                'ca.id',
                'ca.created_at',
                'ca.application_no',
                'ca.status',
                'am.remarks',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'ConversionApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query4->where(function ($query) use ($searchValue) {
                $query->where('ca.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('ca.created_at', 'like', "%$searchValue%");
            });
        }

        // Add Noc Application - Lalit (19/March/2025)
        $query5 = DB::table('noc_applications as noc')
            ->leftJoin('property_masters', 'noc.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoinSub($latestAppMovements, 'am', function ($join) {
                $join->on('noc.application_no', '=', 'am.application_no');
            })
            ->where('noc.created_by', '=', Auth::id())
            ->where('noc.status', '!=', getServiceType('APP_WD'))
            ->select(
                'noc.id',
                'noc.created_at',
                'noc.application_no',
                'noc.status',
                'am.remarks',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'NocApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('noc.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('noc.created_at', 'like', "%$searchValue%");
            });
        }

        $clonedQuery1 = (clone $query1);
        $clonedQuery2 = (clone $query2);
        $clonedQuery3 = (clone $query3);
        $clonedQuery4 = (clone $query4);
        $clonedQuery5 = (clone $query5);

        // Combine all three queries using UNION
        $combinedQuery = $clonedQuery1->union($clonedQuery2)->union($clonedQuery3)->union($clonedQuery4)->union($clonedQuery5);
        // $combinedQuery = $clonedQuery1;

        $limit = $request->input('length');
        $start = $request->input('start');
        if ($request->input('order.0.column')) {
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        } else {
            $order = 'created_at';
            $dir = 'desc';
        }


        $totalData = $combinedQuery->count();
        $totalFiltered = $totalData;

        // Pagination parameters
        $limit = $request->input('length');
        $start = $request->input('start');

        // Apply ordering and limit/offset
        $applications = $combinedQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = [];
        foreach ($applications as $key => $application) {
            //Allow edit applications - Lalit tiwari (02/12/2024)
            $editFlag = false;
            $recordExists = ApplicationAppointmentLink::where('application_no', $application->application_no)->where('is_attended', true)->exists();
            //Check applicant didn't came for proof reading. - Lalit tiwari (03/dec/2024)
            if (!$recordExists && $application->status == $objectId) {
                $editFlag = true;
            }
            $nestedData['id'] = $key + 1;
            $nestedData['application_no'] = $application->application_no;
            $nestedData['old_property_id'] = $application->old_propert_id;
            $nestedData['new_colony_name'] = $application->colony_name;
            $nestedData['block_no'] = $application->block_no;
            $nestedData['plot_or_property_no'] = $application->plot_or_property_no;
            $nestedData['presently_known_as'] = $application->presently_known_as;
            $flatHTML = '';
            if (!empty($application->flat_id)) {
                $flatHTML .= '<div class="d-flex gap-2 align-items-center">' . $application->flat_number . '</div><span class="text-secondary">(' . $application->flat_id . ')</span>';
            } else {
                $flatHTML .= '<div>NA</div>';
            }
            $nestedData['flat_id'] =   $flatHTML;

            switch ($application->model_name) {
                case 'MutationApplication':
                    $appliedFor = 'Mutation';
                    break;
                case 'LandUseChangeApplication':
                    $appliedFor = 'LUC';
                    break;
                case 'DeedOfApartmentApplication':
                    $appliedFor = 'DOA';
                    break;
                case 'ConversionApplication':
                    $appliedFor = 'CONVERSION';
                    break;
                case 'NocApplication':
                    $appliedFor = 'NOC';
                    break;
                default:
                    // Default action
                    break;
            }
            //for getting status
            $item = getStatusDetailsById($application->status);
            $itemCode = $item->item_code;
            $itemName = $item->item_name;
            $itemColor = $item->color_code;
            $statusClasses = [
                'APP_REJ' => 'statusRejected',
                'APP_NEW' => 'statusNew',
                'APP_IP' => 'statusSecondary',
                'RS_REW' => 'text-white bg-secondary',
                'RS_PEN' => 'text-info bg-light-info',
                'APP_APR' => 'landtypeFreeH',
                'APP_OBJ' => 'statusObject',
                'APP_HOLD' => 'statusHold',
            ];
            $class = $statusClasses[$itemCode] ?? 'text-secondary bg-light';

            $nestedData['applied_for'] = '<label class="badge bg-info mx-1">' . $appliedFor . '</label>';
            $nestedData['status'] = '<span class="highlight_value ' . $class . '">' . ucwords($itemName) . '</span>';
            $nestedData['remark'] = $application->remarks ? Str::limit($application->remarks, 20) . " <a href='javascript:void(0)' class='text-primary' onclick='viewRemark(\"" . $application->remarks . "\")'>View</a>" : "";
            $model = base64_encode($application->model_name);
            // Prepare actions
            $action =  '<div class="d-flex gap-3">';
            $action .= '<a href="' . url('edharti/applications/' . $application->id) . '?type=' . $model . '">
                            <button type="button" class="btn btn-primary px-5">View</button>
                        </a>';
            if ($itemName === 'New') {
                $action .= '
                <button type="button" class="btn btn-danger px-3" onclick="withdrawApplication(\'' . $application->application_no . '\')">Withdraw Application</button>';
            }
            if ($editFlag == true) {
                $objectedAction = base64_encode('objectApplication');
                $action .= '<a href="' . url('edharti/applications/edit/' . $application->id) . '?type=' . $model . '&action=' . $objectedAction . '"><button type="button" class="btn btn-primary px-3">Edit</button></a>';
            }
            $action .=  '</div>';
            $nestedData['action'] = $action;
            // $action = '<button type="button" class="btn btn-danger px-5" onclick="withdrawApplication(\'' . $application->application_no . '\')">Withdraw Application</button>';
            // $nestedData['action'] = $action;

            $nestedData['created_at'] = Carbon::parse($application->created_at)
                ->setTimezone('Asia/Kolkata')
                ->format('d M Y H:i:s');

            $data[] = $nestedData;
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }

    //for withdraw the applications - - SOURAV CHAUHAN (7/oct/2024)
    public function withdrawApplication(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $applicationNo = $request->applicationNo;
                $status = getServiceType('APP_WD');

                //withdraw in applications table
                $application = Application::where('application_no', $applicationNo)->first();
                if ($application->status == getServiceType('APP_NEW')) {
                    $application->status = $status;
                    if ($application->save()) {
                        $modelName = $application->model_name;
                        $modelId = $application->model_id;
                        switch ($modelName) {
                            case 'MutationApplication':
                                $serviceType = getServiceType('SUB_MUT');
                                $mutationApplication = MutationApplication::find($modelId);
                                $mutationApplication->status = $status;
                                $mutationApplication->save();
                                break;
                            case 'DeedOfApartmentApplication':
                                $serviceType = getServiceType('DOA');
                                $mutationApplication = DeedOfApartmentApplication::find($modelId);
                                $mutationApplication->status = $status;
                                $mutationApplication->save();
                                break;
                            case 'LandUseChangeApplication':
                                $serviceType = getServiceType('LUC');
                                $lucApplication = LandUseChangeApplication::find($modelId);
                                $lucApplication->status = $status;
                                $lucApplication->save();
                                break;
                            case 'ConversionApplication': //case for conversion application // added by nitin
                                $serviceType = getServiceType('CONVERSION');
                                $conversionApplication = ConversionApplication::find($modelId);
                                $conversionApplication->status = $status;
                                $conversionApplication->save();
                                break;
                            case 'NocApplication': //case for noc application // added by Lalit (19/march/2025)
                                $serviceType = getServiceType('NOC');
                                $conversionApplication = NocApplication::find($modelId);
                                $conversionApplication->status = $status;
                                $conversionApplication->save();
                                break;
                            default:
                                break;
                        }
                        //entry to application movement for withdraw
                        $applicationMovement = ApplicationMovement::create([
                            // 'assigned_by' => Auth::user()->id,
                            'service_type' => $serviceType, //for mutation,LUC,DOA etc
                            'model_id' => $modelId,
                            'status' => getServiceType('APP_WD'), //for new application, objected application, rejected, approved etc
                            'application_no' => $applicationNo,
                        ]);

                        if ($applicationMovement) {
                            $response = ['status' => true, 'message' => 'Application Withdrawn Successfully'];
                        } else {
                            Log::info("| " . Auth::user()->email . " | issue in saving to application movement table");
                            $response = ['status' => false, 'message' => 'Application not Withdrawn'];
                        }
                    } else {
                        Log::info("| " . Auth::user()->email . " | issue in saving to applications table");
                        $response = ['status' => false, 'message' => 'Application not Withdrawn'];
                    }
                } else {
                    Log::info("| " . Auth::user()->email . " | Appication is withdrawn or any other process is done on it, so cant withdraw");
                    $response = ['status' => false, 'message' => "Some process is running on Application, so can't be Withdrawn"];
                }
                return json_encode($response);
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $response = ['status' => false, 'message' => $e->getMessage()];
            return json_encode($response);
        }
    }


    //for withdraw applications view - SOURAV CHAUHAN (8/oct/2024)
    public function applicationsWithdrawDetails()
    {
        return view('application.withdraw.index');
    }

    //for fetching the applications which are withdraw successfully - SOURAV CHAUHAN (8/oct/2024)
    public function getWithdrawApplications(Request $request)
    {
        // Define the columns that can be ordered and searched
        $columns = [
            'id', // index 0
            'application_no', // index 1
            'old_propert_id', // index 2
            'new_colony_name', // index 3
            'block_no', // index 4
            'plot_or_property_no', // index 5
            'flat_id', // index 6
            'presently_known_as', // index 7
            'applied_for', // index 8
            'created_at', // index 9
        ];

        // Define the first table query
        $query1 = DB::table('mutation_applications as ma')
            ->leftJoin('property_masters', 'ma.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('ma.created_by', '=', Auth::id())
            ->where('ma.status', '=', getServiceType('APP_WD'))
            ->select(
                'ma.id',
                'ma.created_at',
                'ma.application_no',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'MutationApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('ma.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('ma.created_at', 'like', "%$searchValue%");
            });
        }


        // Start query
        $query2 = DB::table('land_use_change_applications as lca')
            ->leftJoin('property_masters', 'lca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('lca.created_by', '=', Auth::id())
            ->where('lca.status', '=', getServiceType('APP_WD'))
            ->select(
                'lca.id',
                'lca.created_at',
                'lca.application_no',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'LandUseChangeApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query2->where(function ($query) use ($searchValue) {
                $query->where('lca.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('lca.created_at', 'like', "%$searchValue%");
            });
        }

        // Define the third table query
        $query3 = DB::table('deed_of_apartment_applications as doa')
            ->leftJoin('property_masters', 'doa.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->leftJoin('flats', 'doa.flat_id', '=', 'flats.id')
            ->where('doa.created_by', '=', Auth::id())
            ->where('doa.status', '=', getServiceType('APP_WD'))
            ->select(
                'doa.id',
                'doa.created_at',
                'doa.application_no',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                'flats.unique_flat_id as flat_id', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                'flats.flat_number as flat_number', // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw("'DeedOfApartmentApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query3->where(function ($query) use ($searchValue) {
                $query->where('doa.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('flats.unique_flat_id', 'like', "%$searchValue%")  // Search By Flat Id
                    ->orWhere('flats.flat_number', 'like', "%$searchValue%")  // Search By Flat Number
                    ->orWhere('doa.created_at', 'like', "%$searchValue%");
            });
        }

        // Define the third table query
        $query4 = DB::table('conversion_applications as ca')
            ->leftJoin('property_masters', 'ca.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('ca.created_by', '=', Auth::id())
            ->where('ca.status', '=', getServiceType('APP_WD'))
            ->select(
                'ca.id',
                'ca.created_at',
                'ca.application_no',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'ConversionApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query4->where(function ($query) use ($searchValue) {
                $query->where('ca.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('ca.created_at', 'like', "%$searchValue%");
            });
        }

        // Add query for Noc - Lalit tiwari (19/march/2025)
        $query5 = DB::table('noc_applications as noc')
            ->leftJoin('property_masters', 'noc.property_master_id', '=', 'property_masters.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('property_lease_details', 'property_masters.id', '=', 'property_lease_details.property_master_id')
            ->where('noc.created_by', '=', Auth::id())
            ->where('noc.status', '=', getServiceType('APP_WD'))
            ->select(
                'noc.id',
                'noc.created_at',
                'noc.application_no',
                'property_masters.old_propert_id',
                'property_masters.new_colony_name',
                'old_colonies.name as colony_name',
                'property_masters.block_no',
                'property_masters.plot_or_property_no',
                'property_lease_details.presently_known_as',
                DB::raw('NULL as flat_id'), // Add NULL for flat_id on dated 07/01/25 By Lalit Tiwari
                DB::raw('NULL as flat_number'), // Add NULL for flat_number on dated 07/01/25 By Lalit Tiwari
                DB::raw("'NocApplication' as model_name") // Add model_name for the first query
            );

        // Add search filter if search.value is present
        if ($request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $query1->where(function ($query) use ($searchValue) {
                $query->where('noc.application_no', 'like', "%$searchValue%")
                    ->orWhere('property_masters.old_propert_id', 'like', "%$searchValue%")  // Use the correct column alias here
                    ->orWhere('property_masters.new_colony_name', 'like', "%$searchValue%")  // Correctly reference new_colony_name
                    // ->orWhere('old_colonies.name', 'like', "%$searchValue%")  // Correctly reference old_colony_name
                    ->orWhere(DB::raw('LOWER(old_colonies.name)'), 'like', '%' . strtolower($searchValue) . '%')
                    ->orWhere('property_masters.block_no', 'like', "%$searchValue%")  // Correctly reference block
                    ->orWhere('property_masters.plot_or_property_no', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('property_lease_details.presently_known_as', 'like', "%$searchValue%")  // Correctly reference plot
                    ->orWhere('noc.created_at', 'like', "%$searchValue%");
            });
        }

        $clonedQuery1 = (clone $query1);
        $clonedQuery2 = (clone $query2);
        $clonedQuery3 = (clone $query3);
        $clonedQuery4 = (clone $query4);
        $clonedQuery5 = (clone $query5); // Append Noc Query - Lalit (19/march/2025)

        // Combine all three queries using UNION
        $combinedQuery = $clonedQuery1->union($clonedQuery2)->union($clonedQuery3)->union($clonedQuery4)->union($clonedQuery5);
        // $combinedQuery = $clonedQuery1;

        $limit = $request->input('length');
        $start = $request->input('start');
        if ($request->input('order.0.column')) {
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        } else {
            $order = 'created_at';
            $dir = 'desc';
        }


        $totalData = $combinedQuery->count();
        $totalFiltered = $totalData;

        // Pagination parameters
        $limit = $request->input('length');
        $start = $request->input('start');

        // Apply ordering and limit/offset
        $applications = $combinedQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        // dd($applications);
        foreach ($applications as $key => $application) {
            $nestedData['id'] = $key + 1;
            $nestedData['application_no'] = $application->application_no;
            $nestedData['old_property_id'] = $application->old_propert_id;
            $nestedData['new_colony_name'] = $application->colony_name;
            $nestedData['block_no'] = $application->block_no;
            $nestedData['plot_or_property_no'] = $application->plot_or_property_no;
            $nestedData['presently_known_as'] = $application->presently_known_as;
            $flatHTML = '';
            if (!empty($application->flat_id)) {
                $flatHTML .= '<div class="d-flex gap-2 align-items-center">' . $application->flat_number . '</div><span class="text-secondary">(' . $application->flat_id . ')</span>';
            } else {
                $flatHTML .= '<div>NA</div>';
            }
            $nestedData['flat_id'] =   $flatHTML;

            switch ($application->model_name) {
                case 'MutationApplication':
                    $appliedFor = 'Mutation';
                    break;
                case 'DeedOfApartmentApplication':
                    $appliedFor = 'DOA';
                    break;
                case 'LandUseChangeApplication':
                    $appliedFor = 'LUC';
                    break;
                case 'ConversionApplication':
                    $appliedFor = 'CONVERSION';
                    break;
                case 'NocApplication':
                    $appliedFor = 'NOC';
                    break;
                default:
                    // Default action
                    break;
            }
            $nestedData['applied_for'] = '<label class="badge bg-info mx-1">' . $appliedFor . '</label>';
            $model = base64_encode($application->model_name);

            // Prepare actions
            // $action = '<button type="button" class="btn btn-danger px-5" onclick="withdrawApplication(\'' . $application->application_no . '\')">Withdraw Application</button>';
            // $nestedData['action'] = $action;
            $nestedData['created_at'] = Carbon::parse($application->created_at)
                ->setTimezone('Asia/Kolkata')
                ->format('d M Y H:i:s');

            $data[] = $nestedData;
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }
    //for deleting application  - SOURAV CHAUHAN -- moved to ApplicationController from MutationController and modified by Nitin on 08-10-2024
    public function deleteApplication(Request $request)
    {
        // dd($request->all());
        $transactionSuccess = false;
        DB::transaction(function () use ($request, &$transactionSuccess) {
            $applicationId = $request->modalId;
            if (isset($request->modalName)) {
                $tempModelName = $request->modalName;
                $model = '\\App\\Models\\' . $tempModelName;
                $instance = new $model();
                $serviceType = getServiceType($instance->serviceType->item_code);
                // dd($serviceType);
            } else {
                $applicationType = $request->applicationType;
                $keyInConfig = $applicationType;
                if ($applicationType == 'SUB_MUT') {
                    $keyInConfig = 'MUTATION';
                }
                $tempModelName = config('applicationDocumentType.' . $keyInConfig . '.TempModelName');
                $serviceType = getServiceType($applicationType);
            }

            // Delete application
            $instance = new GeneralFunctions();
            $deleted = $instance->deleteApplicationAllTempData($tempModelName, $applicationId, $serviceType);
            if ($deleted) {
                $transactionSuccess = true;
            }
        });

        // Determine the response based on the transaction success
        if ($transactionSuccess) {
            $response = ['status' => true, 'message' => 'Data deleted successfully'];
        } else {
            $response = ['status' => false, 'message' => 'Something went wrong!'];
        }
        return json_encode($response);
    }

    public function deleteUploadedTempDocument(Request $request)
    {
        if (isset($request->id) && $request->id > 0) {
            $docToDelete = TempDocument::find($request->id);
        } else {
            if (isset($request->modelId) && isset($request->index) && isset($request->documentType) && isset($request->applicationType)) {
                $applicationType = $request->applicationType;
                if ($applicationType == "SUB_MUT")
                    $applicationType = "MUTATION"; //special case for substitution mutation
                $modelName = config('applicationDocumentType.' . $applicationType . '.TempModelName');
                $docToDelete = TempDocument::where('index_no', $request->index)->where('model_id', $request->modelId)->where('model_name', $modelName)->where('document_type', $request->documentType)->first();
            } else {
                return response()->json(['status' => false, 'messaage' => 'Can not complete this operation. Required data not provided']);
            }
        }

        if (empty($docToDelete)) {
            //document dont exist anyway. so continue with frontend operation
            return response()->json(['status' => true]);
        }
        $documentKeys = $docToDelete->documentKeys;
        if ($documentKeys) {
            foreach ($documentKeys as $key) {
                TempDocumentKey::find($key->id)?->delete();
            }
        }
        if (Storage::disk('public')->exists($docToDelete->file_path)) {
            Storage::disk('public')->delete($docToDelete->file_path);
        }
        $docToDelete->delete();
        return response()->json(['status' => true]);
    }
    public function deleteTempCoapplicant(Request $request)
    {
        // dd($request->all());
        if (isset($request->id) && $request->id > 0) {
            $coapplicantToDelete = TempCoapplicant::find($request->id);
        } else {
            if (isset($request->modelId) && isset($request->index) && isset($request->applicationType)) {
                $applicationType = $request->applicationType;
                if ($applicationType == "SUB_MUT")
                    $applicationType = "MUTATION"; //special case for substitution mutation
                $modelName = config('applicationDocumentType.' . $applicationType . '.TempModelName');
                // dd(TempCoapplicant::where('index_no', $request->index)->where('model_id', $request->modelId)->where('model_name', $modelName)->toSql(), TempCoapplicant::where('index_no', $request->index)->where('model_id', $request->modelId)->where('model_name', $modelName)->getBindings());
                $coapplicantToDelete = TempCoapplicant::where('index_no', $request->index)->where('model_id', $request->modelId)->where('model_name', $modelName)->first();
                // dd($coapplicantToDelete);
            } else {
                return response()->json(['status' => false, 'messaage' => 'Can not complete this operation. Required data not provided']);
            }
        }

        if (empty($coapplicantToDelete)) {
            //document dont exist anyway. so continue with frontend operation
            return response()->json(['status' => true]);
        }
        if ($coapplicantToDelete->aadhaar_file_path != null) {
            if (Storage::disk('public')->exists($coapplicantToDelete->aadhaar_file_path)) {
                Storage::disk('public')->delete($coapplicantToDelete->aadhaar_file_path);
            }
        }
        if ($coapplicantToDelete->pan_file_path != null) {
            if (Storage::disk('public')->exists($coapplicantToDelete->pan_file_path)) {
                Storage::disk('public')->delete($coapplicantToDelete->pan_file_path);
            }
        }
        if ($coapplicantToDelete->image_path != null) {
            if (Storage::disk('public')->exists($coapplicantToDelete->image_path)) {
                Storage::disk('public')->delete($coapplicantToDelete->image_path);
            }
        }
        $coapplicantToDelete->delete();
        return response()->json(['status' => true]);
    }

    //for fetching flat detals by flat id - Lalit tiwari - 11/nov/2024
    public function appGetFlatDetails(Request $request)
    {
        $flatDetails = Flat::find($request->flatId);
        if (!empty($flatDetails)) {
            if (!empty($flatDetails)) {
                $data['flatDetails'] = $flatDetails;
                $response = ['status' => true, 'message' => 'Provided Property is available.', 'data' => $data];
            } else {
                $response = ['status' => false, 'message' => 'Provided Property ID is not available.', 'data' => NULL];
            }
            return $response;
        }
    }

    //for fetching status of applicant - Lalit tiwari - 28/march/2025
    public function getStatusOfApplicantData(Request $request)
    {
        $oldPropertyId = $request->propertyId;
        $updateId = $request->updateId;
        $draftApplicationPropertyId = $request->draftApplicationPropertyId;

        //for edit case
        if ($draftApplicationPropertyId == 'true') {
            $decodedModel = $request->model;

            $model = '\\App\\Models\\' . $decodedModel;
            if (!class_exists($model)) {
                return redirect()->back();
            }
            $instance = new $model();
            $serviceType = $instance->serviceType;
        }

        //$data['applicationTypeOption'] = "<option value='$serviceType->item_code'>$serviceType->item_name</option>";

        // dd($draftApplicationPropertyId,$updateId);
        if ($draftApplicationPropertyId == 'false' && $updateId != 0) {
            $response = ['status' => false, 'message' => 'Data should be deleted', 'data' => 'deleteYes'];
        } else {
            $propertyDetails = PropertyMaster::where('old_propert_id', $oldPropertyId)->first();
            $data = [];
            $data['propertyDetails'] = Self::getPropertyCommonDetails($oldPropertyId);
            $data['items'] = [];
            $inFavourCon = [];
            $transferDate = '';
            if ($propertyDetails) {
                $data['status'] = $propertyDetails['status'];
                if ($data['status'] == '952') {
                    //if free hold
                    // dd($propertyDetails);
                    $conversionDetails = PropertyTransferredLesseeDetail::where('property_master_id', $propertyDetails['id'])->where('process_of_transfer', 'Conversion')->get();
                    foreach ($conversionDetails as $conversionDetail) {
                        $name = $conversionDetail->lessee_name;
                        $transferDate = $conversionDetail->transferDate;
                        $inFavourCon[] = $name;
                    }
                    // dd($inFavour);

                    // process_of_transfer
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceType->item_code];
                    } else {
                        $itemCodes = ['NOC', 'SUB_MUT', 'PRP_CERT'];
                    }
                } else {
                    //if lease hold
                    if ($draftApplicationPropertyId == 'true') {
                        $itemCodes = [$serviceType->item_code];
                    } else {
                        //Check if property related to flatid then only DOA application type should be populated - Lalit Tiwari on 11/Nov/2024
                        $userProperty = UserProperty::where('old_property_id', $oldPropertyId)->where('user_id', Auth::id())->first();
                        if (!empty($userProperty->flat_id)) {
                            $itemCodes = ['DOA'];
                        } else {
                            $itemCodes = ['LUC', 'CONVERSION', 'SEL_PERM', 'PRP_CERT', 'SUB_MUT'];
                        }
                        // $itemCodes = ['LUC', 'DOA', 'CONVERSION', 'SEL_PERM', 'PRP_CERT', 'SUB_MUT'];
                    }
                }

                $data['inFavourCon'] = implode(', ', $inFavourCon);
                $data['transferDate'] = $transferDate;
                $items = Item::whereIn('item_code', $itemCodes)->where('is_active', 1)->pluck('item_name', 'item_code');
                if ($items) {
                    $data['items'] = $items;
                }
                $response = ['status' => true, 'message' => 'Provided Property is available.', 'data' => $data];
            } else {
                $response = ['status' => false, 'message' => 'Provided Property ID is not available.', 'data' => NULL];
            }
        }
        return $response;
    }

    //for storing applicant status and file deletion on condiition - SOURAV CHAUHAN (15 April 2025)
    public function updateApllicantStatus(Request $request)
    {
        $applicationTempId = $request->appTempId;
        $applicantStatus = $request->selectedValue;
        switch ($request->applicationType) {
            case 'SUB_MUT':
                $model = 'TempSubstitutionMutation';
                break;
            case 'PRP_CERT':
                $model = "";
                break;
            case 'NOC':
                $model = 'TempNoc';
                break;
            case 'LUC':
                $model = 'TempLandUseChangeApplication';
                break;
            case 'DOA':
                $model = 'TempDeedOfApartment';
                break;
            case 'CONVERSION':
                $model = 'TempConversionApplication';
                break;
            case 'SEL_PERM':
                $model = '';
                break;
        }
        $tempApplication = ('App\\Models\\' . $model)::find($applicationTempId);
        if ($tempApplication) {
            $tempApplication->status_of_applicant = $applicantStatus;
            if ($tempApplication->save()) {
                $document = TempDocument::where('model_name', $model)->where('model_id', $applicationTempId)->where('document_type', 'documentpowerofattorney')->first();
                if ($document) {
                    if (Storage::disk('public')->exists($document->file_path)) {
                        Storage::disk('public')->delete($document->file_path);
                    }
                    $document->delete();
                }
            }
            $response = ['status' => true, 'message' => 'Applicant status updated successfully'];
            return json_encode($response);
        } else {
            $response = ['status' => false, 'message' => 'Applicant status not updated'];
            return json_encode($response);
        }
    }
}
