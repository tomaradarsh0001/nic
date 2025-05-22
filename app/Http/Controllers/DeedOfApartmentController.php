<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GeneralFunctions;
use App\Models\Flat;
use App\Models\TempDeedOfApartment;
use App\Models\Payment;
use App\Models\PropertyMaster;
use App\Models\SplitedPropertyDetail;
use App\Models\TempDocument;
use App\Services\PropertyMasterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeedOfApartmentController extends Controller
{
    public function deedOfApartmentStepFirstStore(Request $request, PropertyMasterService $propertyMasterService)
    {
        //Form field validation - Lalit tiwari (9/oct/2024)
        $validator = Validator::make($request->all(), [
            'propertyStatus' => 'required',
            'statusofapplicant' => 'required',
            'applicantName' => 'required',
            'applicantAddress' => 'required',
            'buildingName' => 'required',
            // 'locality' => 'required',
            // 'block' => 'required',
            // 'plot' => 'required',
            // 'knownas' => 'required',
            // 'flatNumber' => 'required',
            // 'builderName' => 'required',
            'flatId' => 'required',
            'originalBuyerName' => 'required',
            'presentOccupantName' => 'required',
            'purchasedFrom' => 'required',
            'purchaseDate' => 'required',
            'apartmentArea' => 'required',
            'plotArea' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill all fields first.']);
        }

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
            $properties = $propertyMasterService->propertyFromSelected($request->propertyid);
            if ($properties['status'] == 'error') {
                return response()->json($properties);
            }
            $masterProperty = $properties['masterProperty'];
            $childProperty = isset($properties['childProperty']) ? $properties['childProperty'] : null;
            $splitedId = !is_null($childProperty) ? $childProperty->id : null;

            if ($updateId == 0) {
                if(!empty($request->flatId)){
                    $recordExists = TempDeedOfApartment::where('property_master_id', $masterProperty->id)->where('flat_id', $request->flatId)->where(function ($query) use ($childProperty) {
                        if (is_null($childProperty))
                            return $query->whereNull('splited_property_detail_id');
                        else
                            return $query->where('splited_property_detail_id', $childProperty->id);
                    })->exists();
                } else {
                    $recordExists = TempDeedOfApartment::where('property_master_id', $masterProperty->id)->where(function ($query) use ($childProperty) {
                        if (is_null($childProperty))
                            return $query->whereNull('splited_property_detail_id');
                        else
                            return $query->where('splited_property_detail_id', $childProperty->id);
                    })->exists();
                }
                $recordExists = TempDeedOfApartment::where('property_master_id', $masterProperty->id)->where(function ($query) use ($childProperty) {
                    if (is_null($childProperty))
                        return $query->whereNull('splited_property_detail_id');
                    else
                        return $query->where('splited_property_detail_id', $childProperty->id);
                })->exists();
                if ($recordExists) {
                       return response()->json(['status' => false, 'message' => config('messages.doa.error.applicationAlreadyExist')]);
                }
            }
          
            // Check if record is coming for update with updateId Lalit tiwari (09/Oct/2024)
            if ($updateId != '0') {
                DB::transaction(function () use ($request, &$transactionSuccess, &$updateId, &$tempDOA, &$propertyStatus) {
                    $flatDetails = Flat::find($request->flatId);
                    $tempDOA = TempDeedOfApartment::find($updateId);
                    if (isset($tempDOA)) {
                        $tempDOA->property_status = !empty($propertyStatus) ? $propertyStatus : $tempDOA->property_status;
                        $tempDOA->status_of_applicant = !empty($request->statusofapplicant) ? $request->statusofapplicant : $tempDOA->status_of_applicant;
                        $tempDOA->applicant_name = !empty($request->applicantName) ? $request->applicantName : $tempDOA->applicant_name;
                        $tempDOA->applicant_address = !empty($request->applicantAddress) ? $request->applicantAddress : $tempDOA->applicant_address;
                        $tempDOA->building_name = !empty($request->buildingName) ? $request->buildingName : $tempDOA->building_name;
                        $tempDOA->locality = !empty($flatDetails['locality']) ? $flatDetails['locality'] : $tempDOA->locality;
                        $tempDOA->block = !empty($flatDetails['block']) ? $flatDetails['block'] : $tempDOA->block;
                        $tempDOA->plot = !empty($flatDetails['plot']) ? $flatDetails['plot'] : $tempDOA->plot;
                        $tempDOA->known_as = !empty($flatDetails['known_as']) ? $flatDetails['known_as'] : $tempDOA->known_as;
                        $tempDOA->flat_id = !empty($flatDetails['id']) ? $flatDetails['id'] : $tempDOA->flat_id;
                        $tempDOA->isFlatNotListed = !empty($request->isFlatNotListed) ? true : $tempDOA->isFlatNotListed;
                        $tempDOA->flat_number = !empty($flatDetails['flat_number']) ? $flatDetails['flat_number'] : $tempDOA->flat_number;
                        $tempDOA->builder_developer_name = !empty($flatDetails['builder_developer_name']) ? $flatDetails['builder_developer_name'] : $tempDOA->builder_developer_name;
                        $tempDOA->original_buyer_name = !empty($request->originalBuyerName) ? $request->originalBuyerName : $tempDOA->original_buyer_name;
                        $tempDOA->present_occupant_name = !empty($request->presentOccupantName) ? $request->presentOccupantName : $tempDOA->present_occupant_name;
                        $tempDOA->purchased_from = !empty($request->purchasedFrom) ? $request->purchasedFrom : $tempDOA->purchased_from;
                        $tempDOA->purchased_date = !empty($request->purchaseDate) ? $request->purchaseDate : $tempDOA->purchased_date;
                        $tempDOA->flat_area = !empty($request->apartmentArea) ? $request->apartmentArea : $tempDOA->flat_area;
                        $tempDOA->plot_area = !empty($request->plotArea) ? $request->plotArea : $tempDOA->plot_area;
                        $tempDOA->updated_by = Auth::user()->id;
                        if ($tempDOA->save()) {
                            $transactionSuccess = true;
                        }
                    }
                });
            } else {
                $propertyDetails = PropertyMaster::where('old_propert_id', $request->propertyid)->first();
                DB::transaction(function () use ($request, &$transactionSuccess, &$propertyDetails, &$tempDOA, &$propertyStatus, &$oldPropertyId, &$newPropertyId, &$masterPropertyId, &$splittedPropertyId, &$flatDetails) {
                    $flatDetails = Flat::find($request->flatId);
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
                        'locality'   => !empty($flatDetails['locality']) ? $flatDetails['locality'] : null,
                        'block'   => !empty($flatDetails['block']) ? $flatDetails['block'] : null,
                        'plot'   => !empty($flatDetails['plot']) ? $flatDetails['plot'] : null,
                        'known_as'   => !empty($flatDetails['known_as']) ? $flatDetails['known_as'] : null,
                        'flat_id'   => !empty($flatDetails['id']) ? $flatDetails['id'] : null,
                        'isFlatNotListed'   => !empty($request->isFlatNotListed) ? true : false,
                        'flat_number'   => !empty($flatDetails['flat_number']) ? $flatDetails['flat_number'] : null,
                        'builder_developer_name'   => !empty($flatDetails['builder_developer_name']) ? $flatDetails['builder_developer_name'] : null,
                        'original_buyer_name'   => !empty($request->originalBuyerName) ? $request->originalBuyerName : null,
                        'present_occupant_name'   => !empty($request->presentOccupantName) ? $request->presentOccupantName : null,
                        'purchased_from'   => !empty($request->purchasedFrom) ? $request->purchasedFrom : null,
                        'purchased_date'   => !empty($request->purchaseDate) ? $request->purchaseDate : null,
                        'flat_area'   => !empty($request->apartmentArea) ? $request->apartmentArea : null,
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
                $response = ['status' => true, 'message' => config('messages.doa.success.deedOfAparatmentStep1Success'), 'data' => $tempDOA];
            } else {
                $response = ['status' => false, 'message' => config('messages.doa.error.somethingWentWrong'), 'data' => 0];
            }
            return json_encode($response);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $response = ['status' => false, 'message' => $e->getMessage(), 'data' => 0];
            return json_encode($response);
        }
    }

    public function deedOfApartmentStepFinalStore(Request $request)
    {

        // Check if all document has been uploaded. Lalit Tiwari (09/Oct/2024)
        $documentsRequired = array_keys(config('applicationDocumentType.DOA.documents'));
        foreach ($documentsRequired as $document) {
            $serviceType = getServiceType('DOA');
            $isDocUploaded = TempDocument::where('service_type', $serviceType)->where('model_id', $request->updateId)->where('document_type', $document)->first();
            if (empty($isDocUploaded)) {
                Log::info("| " . Auth::user()->email . " | All documents not uploaded");
                return response()->json(['status' => false, 'message' => 'Please provide all required documents.']);
            }
        }

        $consent = $request->agreeConsent;
        if ($consent != 1) {
            return response()->json(['status' => false, 'message' => 'Please agree to terms & conditions']);
        }

        try {
            return DB::transaction(function () use ($request) {
                $appDoaId = $request->updateId;
                if (isset($appDoaId)) { //if hidden ID available
                    $serviceType = getServiceType('DOA');
                    $apllication = TempDeedOfApartment::where('id', $appDoaId)->first();
                    $apllication->undertaking = $request->agreeConsent;
                    // $apllication->undertaking = $request->has('agreeConsent') ? 1 : 0;
                    if ($apllication->save()) {
                        $tempModelName = config('applicationDocumentType.DOA.TempModelName');
                        $paymentComplete = GeneralFunctions::paymentComplete($request->updateId, $tempModelName);
                        if ($paymentComplete) {
                            $transactionSuccess = true;
                            //to convert temp application to fina application - Lalit tiwari (10/Oct/2024)
                            GeneralFunctions::convertTempAppToFinal($request->updateId, $tempModelName,$paymentComplete);
                            $response = ['status' => true, 'message' => 'Details have been saved successfully'];
                        }
                    }
                } else {
                    Log::info("| " . Auth::user()->email . " | Application ID not available in hidden");
                    $response = ['status' => false, 'message' => 'Something went wrong'];
                }
                return json_encode($response);
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while storing appliation documents'], 500);
        }
    }

    

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
}
