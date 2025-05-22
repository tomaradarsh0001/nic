<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempCoapplicant;
use App\Models\PropertyMaster;
use App\Services\PropertyMasterService;
use App\Models\TempDocument;
use App\Models\TempDocumentKey;
use App\Models\Payment;
use App\Models\OldColony;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Helpers\GeneralFunctions;
use App\Models\TempNoc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NocController extends Controller
{
    public function nocStepFirst(Request $request, PropertyMasterService $propertyMasterService)
    {
        // Apply Validation - Lalit Tiwari (17/march/2025)
        $messages = [
            'statusofapplicant.required' => 'Please select the applicant status',
            'conveyanceDeedName.required' => 'Executed in favour of is required',
            'conveyanceExecutedOn.required' => 'Executed on is required',
            'conveyanceRegnoDeed.required' => 'Regn. No. is required',
            'conveyanceBookNoDeed.required' => 'Book No. is required',
            'conveyanceVolumeNo.required' => 'Volume No. is required',
            'conveyancePagenoFrom.required' => 'Page No. From is required',
            'conveyancePagenoTo.required' => 'Page No. To is required',
            'conveyanceRegDate.required' => 'Registration Date is required',
            // 'conveyanceConAppDate.required' => 'Date of Coversion Application is required',
        ];

        $validator = Validator::make($request->all(), [
            'statusofapplicant' => 'required',
            'conveyanceDeedName' => 'required',
            'conveyanceExecutedOn' => 'required',
            'conveyanceRegnoDeed' => 'required',
            'conveyanceBookNoDeed' => 'required',
            'conveyanceVolumeNo' => 'required',
            'conveyancePagenoFrom' => 'required',
            'conveyancePagenoTo' => 'required',
            'conveyanceRegDate' => 'required',
            // 'conveyanceConAppDate' => 'required'
        ], $messages);

        if ($validator->fails()) {
            // Log the error message if validation fails
            Log::info("| " . Auth::user()->email . " | Noc step first all values not entered: " . json_encode($validator->errors()));
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            return DB::transaction(function () use ($request, $propertyMasterService) {
                $tempNoc = null;
                $updateId = $request->updateId;
                $properties = $propertyMasterService->propertyFromSelected($request->propertyid);
                if ($properties['status'] == 'error') {
                    return response()->json($properties);
                }
                $masterProperty = $properties['masterProperty'];
                $childProperty = isset($properties['childProperty']) ? $properties['childProperty'] : null;
                if ($request->propertyStatus == 'Free Hold') {
                    $propertyStatus = 952;
                } else {
                    $propertyStatus = 951;
                }
                $tempNoc = TempNoc::updateOrCreate(
                    ['id' => $updateId],
                    [
                        'old_property_id' => $request->propertyid,
                        'new_property_id' => $masterProperty->unique_propert_id,
                        'property_master_id' => $masterProperty->id,
                        'property_status' => $propertyStatus,
                        'status_of_applicant' => $request->statusofapplicant,
                        'name_as_per_noc_conv_deed' => $request->conveyanceDeedName,
                        'executed_on_as_per_noc_conv_deed' => $request->conveyanceExecutedOn,
                        'reg_no_as_per_noc_conv_deed' => $request->conveyanceRegnoDeed,
                        'book_no_as_per_noc_conv_deed' => $request->conveyanceBookNoDeed,
                        'volume_no_as_per_noc_conv_deed' => $request->conveyanceVolumeNo,
                        'page_no_as_per_noc_conv_deed' => $request->conveyancePagenoFrom . '-' . $request->conveyancePagenoTo,
                        'reg_date_as_per_noc_conv_deed' => $request->conveyanceRegDate,
                        'con_app_date_as_per_noc_conv_deed' => $request->conveyanceConAppDate,
                        'updated_by' => Auth::id(),
                    ]
                );
                if ($tempNoc->wasRecentlyCreated) {
                    $tempNoc->created_by = Auth::id();
                    $tempNoc->save();
                }

                $modelName = 'TempNoc';
                $modelId = $tempNoc->id;
                $serviceType = 'NOC';
                $stepOneSubmit = GeneralFunctions::storeTempCoApplicants($serviceType, $modelName, $modelId, $masterProperty->newColony->code, $request);
                if ($stepOneSubmit) {
                    return response()->json(['status' => 'success', 'message' => 'Property Details Saved Successfully', 'data' => $tempNoc]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
                }
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred while submitting noc application'], 500);
        }
    }

    //Store Noc Final Step Data Lalit Tiwari - (17/march/2025)
    public function nocFinalStep(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $appNocId = $request->updateId;
                if (isset($appNocId)) { //if hidden ID available
                    $isMutAppAvailable = TempNoc::where('id', $appNocId)->first();
                    if (!empty($isMutAppAvailable)) { //if mutation available for this ID
                        $serviceType = getServiceType('NOC');
                        $applicationDocumentType = config('applicationDocumentType.NOC.Required');
                        $doumentDataStored = $this->storeDataForDocuments($request, $serviceType, $applicationDocumentType);
                        $application = TempNoc::where('id', $appNocId)->first();
                        $application->undertaking = $request->agreeConsent;
                        if ($application->save()) {
                            /* $tempModelName = config('applicationDocumentType.NOC.TempModelName');
                            $encodedModelName = base64_encode($tempModelName);
                            $encodedModelId = base64_encode($appNocId);
                            $redirectUrl = route('applicationPayment', [$encodedModelName, $encodedModelId]);
                            return response()->json(['status' => true, 'url' => $redirectUrl]); */
                            $tempModelName = config('applicationDocumentType.NOC.TempModelName');
                            $paymentComplete = GeneralFunctions::paymentComplete($appNocId, $tempModelName);
                            if ($paymentComplete) {
                                $transactionSuccess = true;
                                //Convert temp application to final application - Lalit Tiwari (19/March/2025)
                                GeneralFunctions::convertTempAppToFinal($appNocId, $tempModelName, $paymentComplete);
                                $response = ['status' => true, 'message' => 'Noc application submitted Successfully'];
                            }
                        }
                    } else {
                        Log::info("| " . Auth::user()->email . " | Application not available in database");
                        $response = ['status' => false, 'message' => 'Something went wrong'];
                    }
                } else {
                    Log::info("| " . Auth::user()->email . " | Application ID not available in hidden");
                    $response = ['status' => false, 'message' => 'Something went wrong'];
                }
                return json_encode($response);
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while storing application documents'], 500);
        }
    }

    //Insert documents data - Lalit Tiwari (17/March/2025)
    protected function storeDataForDocuments($request, $serviceType, $applicationDocumentType)
    {
        $doumentDataStored = false;
        $savedDocumentIds = [];
        foreach ($applicationDocumentType as $index => $documentType) {
            $modelName = 'TempNoc';
            $serviceType = getServiceType('NOC');
            $updateId = $request->updateId;
            if ($documentType['multiple']) {
                $count = 1;
                foreach ($request->{$documentType['id']} as $documents) {
                    $docData = [];
                    if (is_array($documents)) {
                        $createDocument = $updateDocument = false;
                        foreach ($documents as $key => $document) {
                            if (!array_key_exists($documentType['id'] . '_oldId', $documents)) {
                                $createDocument = true;
                            }
                            if ($key == $documentType['id'] . '_oldId') {
                                if ($document === null) {
                                    $createDocument = true;
                                } else {
                                    if (array_key_exists($documentType['id'], $documents) && $documentType['id']) {
                                        $updateDocument = true;
                                        $updateDocumentId = $document;
                                    }
                                }
                            }

                            if (is_file($document)) {
                                if ($createDocument) {
                                    $user = Auth::user();
                                    $name = $key . '_' . $count;
                                    $applicantNo = $user->applicantUserDetails->applicant_number;
                                    $tempNoc = TempNoc::find($updateId);
                                    $propertyId = $tempNoc['old_property_id'];
                                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                                    $colonyId = $propertyDetails['new_colony_name'];
                                    $colony = OldColony::find($colonyId);
                                    $colonyCode = $colony->code;
                                    $type = 'noc';

                                    //upload file
                                    $file = $document;
                                    $date = now()->format('YmdHis');
                                    $fileName =  $name . '_' . $date . '.' . $file->extension();
                                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId;
                                    $file = $file->storeAs($pathToUpload, $fileName, 'public');
                                    if ($file) {
                                        $documentUploded = TempDocument::create([
                                            'service_type' => $serviceType,
                                            'model_name' => $modelName, //'TempNoc',
                                            'model_id' => $updateId,
                                            'title' => $documentType['label'],
                                            'document_type' => $documentType['id'],
                                            'file_path' => $file,
                                            'created_by' => Auth::user()->id,
                                        ]);
                                        $savedDocumentIds[$documentType['id']][] = $documentUploded->id;
                                    }
                                }

                                //if update document
                                if ($updateDocument) {
                                    $upoadedDocument = TempDocument::find($updateDocumentId);
                                    $user = Auth::user();
                                    $name = $key . '_' . $count;
                                    $applicantNo = $user->applicantUserDetails->applicant_number;
                                    $tempNoc = TempNoc::find($updateId);
                                    $propertyId = $tempNoc['old_property_id'];
                                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                                    $colonyId = $propertyDetails['new_colony_name'];
                                    $colony = OldColony::find($colonyId);
                                    $colonyCode = $colony->code;
                                    $type = 'noc';

                                    //upload file
                                    $file = $document;
                                    $date = now()->format('YmdHis');
                                    $fileName =  $name . '_' . $date . '.' . $file->extension();
                                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId;

                                    $deletedFile = $upoadedDocument->file_path;
                                    if ($deletedFile) {
                                        if (Storage::disk('public')->exists($deletedFile)) {
                                            Storage::disk('public')->delete($deletedFile);
                                        }
                                        $file = $file->storeAs($pathToUpload, $fileName, 'public');
                                        if ($file) {
                                            $upoadedDocument->file_path = $file;
                                            $upoadedDocument->updated_by = Auth::user()->id;
                                            $upoadedDocument->save();
                                        }
                                    }
                                }
                            } else {
                                if ($key == $documentType['id'] . '_oldId') {
                                } else {
                                    $docData[$key] = $document;
                                }
                            }
                        }

                        //if document uploaded save the document values
                        if ($docData) {
                            $filteredData = array_filter($docData, function ($value) {
                                return !is_null($value);
                            });

                            $arrayCount = count($filteredData);

                            if ($arrayCount > 2) {
                                foreach ($docData as $k => $data) {
                                    if (strpos($k, '_oldId') !== false) {
                                        // Extract the key without '_oldId'
                                        $newKey = str_replace('_oldId', '', $k);
                                        // Find the old ID
                                        $oldId = $data;
                                        // Update the record with the new value
                                        $tempDocumentKey = TempDocumentKey::find($oldId);
                                        if ($tempDocumentKey) {
                                            $tempDocumentKey->value = $docData[$newKey];
                                            $tempDocumentKey->save();
                                        }
                                    }
                                }
                            } else {
                                foreach ($filteredData as $k => $data) {
                                    if (isset($documentUploded)) {
                                        $tempDocumentKey = TempDocumentKey::create([
                                            'temp_document_id' => $documentUploded->id,
                                            'key' => $k,
                                            'value' => $data,
                                            'created_by' => Auth::user()->id
                                        ]);
                                    } else {
                                        // dd($filteredData);

                                        // // Update the record with the new value
                                        // $tempDocumentKey = TempDocumentKey::find($oldId);
                                        // if ($tempDocumentKey) {
                                        //     $tempDocumentKey->value = $docData[$newKey];
                                        //     $tempDocumentKey->save();
                                        // }

                                    }
                                }
                            }
                        }
                    }
                    $count = $count + 1;
                }
            } else {
                // dd($documentType,"inside else");
                $mainId = $documentType['id'];
                $mainLabel = $documentType['label'];
                $inputs = $documentType['inputs'];
                foreach ($inputs as $input) {
                    $id = $input['id'];
                    $label = $input['label'];
                    // dd($request->$id);
                    if ($request->$id) {
                        $savedDocumentDetails = TempDocument::where('service_type', $serviceType)->where('model_id', $updateId)->where('document_type', $mainId)->first();
                        if ($savedDocumentDetails) {
                            $isDocumentValueAvailable = TempDocumentKey::where('temp_document_id', $savedDocumentDetails->id)->where('key', $id)->first();
                            if (!empty($isDocumentValueAvailable)) {
                                // dd('inside if');
                                $isDocumentValueAvailable->value = $request->$id;
                                $isDocumentValueAvailable->updated_by = Auth::user()->id;
                                $isDocumentValueAvailable->save();
                            } else {
                                // dd('inside else');
                                $tempDocumentKey = TempDocumentKey::create([
                                    'temp_document_id' => $savedDocumentDetails->id,
                                    'key' => $id,
                                    'value' => $request->$id,
                                    'created_by' => Auth::user()->id
                                ]);
                            }
                        }
                    }
                    // dd('inside else');
                }
            }
        }
        $doumentDataStored = ['status' => true, 'savedDocumentIds' => $savedDocumentIds];
        return $doumentDataStored;
    }
}
