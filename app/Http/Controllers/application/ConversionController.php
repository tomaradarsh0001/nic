<?php

namespace App\Http\Controllers\application;

use App\Helpers\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Models\PropertyMaster;
use App\Models\TempConversionApplication;
use App\Models\TempDocument;
use App\Models\TempDocumentKey;
use App\Services\PropertyMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConversionController extends Controller
{
    public function step1Submit(Request $request, PropertyMasterService $propertyMasterService)
    {
        // dd($request->all());

        $messages = [
            'statusofapplicant.required' => 'Please select the applicant status',
            'convNameAsOnLease.required' => 'Executed in favour of is required',
            'convExecutedOnAsOnLease.required' => 'Executed on is required',
            'convRegnoAsOnLease.required' => 'Regn. No. is required',
            'convBooknoAsOnLease.required' => 'Book No. is required',
            'convVolumenoAsOnLease.required' => 'Volume No. is required',
            'convPagenoFrom.required' => 'Page No. From is required',
            'convPagenoTo.required' => 'Page No.  To is required',
            'convRegdateAsOnLease.required' => 'Regn. Date. is required',
        ];

        $validator = Validator::make($request->all(), [
            'statusofapplicant' => 'required',
            'convNameAsOnLease' => 'required',
            'convExecutedOnAsOnLease' => 'required',
            'convRegnoAsOnLease' => 'required',
            'convBooknoAsOnLease' => 'required',
            'convVolumenoAsOnLease' => 'required',
            'convPagenoFrom' => 'required',
            'convPagenoTo' => 'required',
            'convRegdateAsOnLease' => 'required'
        ], $messages);

        if ($validator->fails()) {
            // Log the error message if validation fails
            Log::info("| " . Auth::user()->email . " | Conversion step first all values not entered: " . json_encode($validator->errors()));
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            return DB::transaction(function () use ($request, $propertyMasterService) {
                $tempConversion = null;
                $updateId = $request->updateId;
                $properties = $propertyMasterService->propertyFromSelected($request->propertyid);
                if ($properties['status'] == 'error') {
                    return response()->json($properties);
                }
                $masterProperty = $properties['masterProperty'];
                $childProperty = isset($properties['childProperty']) ? $properties['childProperty'] : null;

                $tempConversion = TempConversionApplication::updateOrCreate(
                    ['id' => $updateId],
                    [
                        'old_property_id' => $request->propertyid,
                        'new_property_id' => $masterProperty->unique_propert_id,
                        'property_master_id' => $masterProperty->id,
                        'splited_property_detail_id' => !is_null($childProperty) ? $childProperty->id : null,
                        'status_of_applicant' => $request->statusofapplicant,
                        'applicant_name' => $request->convNameAsOnLease,
                        'relation_prefix' => $request->convRelationPrefix,
                        'relation_name' => $request->convRelationName,
                        'executed_on' => $request->convExecutedOnAsOnLease,
                        'reg_no' => $request->convRegnoAsOnLease,
                        'book_no' => $request->convBooknoAsOnLease,
                        'volume_no' => $request->convVolumenoAsOnLease,
                        'page_no' => $request->convPagenoFrom . '-' . $request->convPagenoTo,
                        'reg_date' => $request->convRegdateAsOnLease,
                        'is_court_order' => $request->courtorderConversion,
                        'case_no' => $request->convCaseNo ?? null,
                        'case_detail' => $request->convCaseDetail ?? null,
                        'is_mortgaged' => $request->propertymortgagedConversion == 1,
                        'updated_by' => Auth::id(),
                    ]
                );
                if ($tempConversion->wasRecentlyCreated) {
                    $tempConversion->created_by = Auth::id();
                    $tempConversion->save();
                }

                /*save documents */
                /** court order */
                $modelName = 'TempConversionApplication';
                $modelId = $tempConversion->id;
                $serviceType = 'CONVERSION';
                if ($request->propertymortgagedConversion == 1) {
                    $file = $request->file('mortgageNoCFile');
                    if ($file) {
                        $documentType = 'mortgageNoCFile';
                        $documentName = "Mortgage NOC File";
                        $uploadedId = $this->uploadDocument($file, null, $modelName, $modelId, $serviceType, $masterProperty->newColony->code, $documentType, $documentName, true);
                        if (!$uploadedId) {
                            return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
                        }
                        $this->storeTempDocKey($uploadedId, 'NOCAttestationDateConversion', $request->NOCAttestationDateConversion);
                        $this->storeTempDocKey($uploadedId, 'NOCIssuedByConversion', $request->NOCIssuedByConversion);
                    }
                }
                if ($request->courtorderConversion == 1) {
                    $file = $request->file('convCourtOrderFile');
                    if ($file) {
                        $documentType = 'convCourtOrderFile';
                        $documentName = "Court order/ decree file";
                        $uploadedId = $this->uploadDocument($file, null, $modelName, $modelId, $serviceType, $masterProperty->newColony->code, $documentType, $documentName, true);
                        if (!$uploadedId) {
                            return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
                        }
                        $this->storeTempDocKey($uploadedId, 'convCourtOrderDate', $request->convCourtOrderDate);
                        $this->storeTempDocKey($uploadedId, 'courtorderattestedbyConversion', $request->courtorderattestedbyConversion);
                    }
                }
                /**mortgage noc */
                if ($request->propertymortgagedConversion == 1) {
                    $file = $request->file('convCourtOrderFile');
                    if ($file) {
                        $documentType = 'mortgageNoCFile';
                        $documentName = "NOC from Mortgagee Bank/Authority";
                        $uploadedId = $this->uploadDocument($file, null, $modelName, $modelId, $serviceType, $masterProperty->newColony->code, $documentType, $documentName, true);
                        if (!$uploadedId) {
                            return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
                        }
                        $this->storeTempDocKey($uploadedId, 'NOCAttestationDateConversion', $request->NOCAttestationDateConversion);
                        $this->storeTempDocKey($uploadedId, 'NOCIssuedByConversion', $request->NOCIssuedByConversion);
                    }
                }
                /** save documents */

                $stepOneSubmit = GeneralFunctions::storeTempCoApplicants($serviceType, $modelName, $modelId, $masterProperty->newColony->code, $request);
                if ($stepOneSubmit) {
                    return response()->json(['status' => 'success', 'message' => 'Property Details Saved Successfully', 'data' => $tempConversion]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
                }
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while conversion appliation submission'], 500);
        }
    }

    private function uploadDocument($file, $documentId, $modelName, $modelId, $serviceType, $colonyCode, $documentType, $documentName, $deleteOriginalFile = false, $indexNo = null)
    {
        // dd($file, $documentId, $modelName, $modelId, $serviceType, $colonyCode, $documentType, $documentName, $deleteOriginalFile, $indexNo);
        $user = Auth::user();
        $applicantNo = $user->applicantUserDetails->applicant_number;
        $date = now()->format('YmdHis');
        $pathToUpload =  $applicantNo . '/' . $colonyCode . '/' . $serviceType . '/' . $modelId;
        $fileName = $documentType . '-' . $date . '.' . $file->getClientOriginalExtension();

        // Save the image to storage
        $fullPath = $pathToUpload .  '/' . $fileName;
        $stored = Storage::disk('public')->put($fullPath, file_get_contents($file));
        if ($documentId != "") {
            $oldRecord = TempDocument::find($documentId);
        } else {
            $oldRecord = TempDocument::where('model_name', $modelName)->where('model_id', $modelId)->where('document_type', $documentType)
                ->where(function ($query) use ($indexNo) {
                    if (is_null($indexNo)) {
                        return $query->whereNull('index_no');
                    } else {
                        return $query->where('index_no', $indexNo);
                    }
                })->first();
        }
        if ($deleteOriginalFile) {
            $fileToDelete = !empty($oldRecord) ? $oldRecord->file_path : null;
            if ($fileToDelete) {
                if (Storage::disk('public')->exists($fileToDelete)) {
                    Storage::disk('public')->delete($fileToDelete);
                }
            }
        }
        if ($stored) {
            $saved = TempDocument::updateOrCreate(['id' => !empty($oldRecord) ? $oldRecord->id : null], [
                'service_type' => getServiceType($serviceType),
                'model_name' => $modelName,
                'index_no' => $indexNo,
                'model_id' => $modelId,
                'title' => $documentName,
                'document_type' => $documentType,
                'file_path' =>  $fullPath,
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]);
            if ($saved)
                return $saved->id;
        }
        return false;
    }

    private function storeTempDocKey($docId, $key, $value)
    {
        return TempDocumentKey::updateOrCreate([
            'temp_document_id' => $docId,
            'key' => $key
        ], [
            'value' => $value
        ]);
    }
    public function step2submit(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'updateId' => 'required|integer',
        ]);
        // try {
        return DB::transaction(function () use ($request) {
            $conversionId = $request->updateId;
            $conversion = TempConversionApplication::find($conversionId);
            $masterProperty = PropertyMaster::find($conversion->property_master_id);
            $requiredDocs = config('applicationDocumentType.CONVERSION.Required');
            foreach ($requiredDocs as $document) {
                $documentRequestKey = $document['id'];
                if ($document['multiple'] === true) {
                    $documentRequestKey = $document['id'] . '_conversion'; // for multiple file '_converion' is added in repeater data-grooup attribute 
                    if (isset($request->{$documentRequestKey}) && count($request->{$documentRequestKey}) > 0) {
                        foreach ($request->{$documentRequestKey} as $uploaedDoc) {
                            $file = $uploaedDoc[$document['id']];
                            $uploadedDocumentId = $uploaedDoc['id'];
                            $uploadIndex = $uploaedDoc['indexNo'];
                            // dd($file, $uploaedDoc, $document['id'], $uploadedDocumentId, $uploadIndex);
                            if ($file) { //when adding new record or updating existing file 
                                $uploadedDocumentId = $this->uploadDocument($file, $uploadedDocumentId, config('applicationDocumentType.CONVERSION.TempModelName'), $request->updateId, 'CONVERSION', $masterProperty->newColony->code, $document['id'], $document['label'], ($uploaedDoc['id'] != ''), $uploadIndex);
                            } else { // when no file is uploaded -  check if it is already added 
                                if ($uploadedDocumentId == "") {
                                    return response()->json(['status' => 'error', "message" => 'File not provided', 'key' => $documentRequestKey, 'id' => $document['id'], 'index' => $uploadIndex], 422);
                                }
                            }
                            /**Save the key values for document */
                            foreach ($document['inputs'] as $input) {
                                if (isset($uploaedDoc[$input['id']])) {
                                    $this->storeTempDocKey($uploadedDocumentId, $input['id'], $uploaedDoc[$input['id']]);
                                }
                            }
                        }
                    }
                } else {
                    // for non multiple file inputs file is already uploaded using saperate function storing values
                    if (isset($document['inputs']) && count($document['inputs']) > 0) {
                        foreach ($document['inputs'] as $key => $input) {
                            if (isset($request->{$input['id']}) && $request->{$input['id']} != '') {
                                $uploadedDoc = TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->first();
                                if (empty($uploadedDoc)) {
                                    //dd(TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->toSql(), TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->getBindings());
                                    return response()->json(['status' => 'error', 'message' => 'An error occurred while appliation upladed document not found, - ' . $document['label']]);
                                }
                                $docId = $uploadedDoc->id;
                                $updated = $this->storeTempDocKey($docId, $input['id'], $request->{$input['id']});
                                if (!$updated) {
                                    return response()->json(['status' => 'error', 'message' => 'something went wrong in saving  the values of input fields']);
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['status' => 'success', 'message' => 'All files uploaded and data saved']);
        });
        /* } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while conversion appliation submission'], 500);
        } */
    }
    public function step3submit(Request $request)
    {
        $request->validate([
            'updateId' => 'required|integer',
            'applicantConsent' => 'required|accepted'
        ]);
        /* try {
        return DB::transaction(function () use ($request) { */
        $conversionId = $request->updateId;
        $conversion = TempConversionApplication::find($conversionId);
        // $masterProperty = PropertyMaster::find($conversion->property_master_id);
        $optionalGroups = config('applicationDocumentType.CONVERSION.optional.groups');
        foreach ($optionalGroups as $group) {
            if (isset($group['input'])) {
                // is lease deed lost there is only one input right now
                $conversion->update(['is_Lease_deed_lost' => $request->{$group['input']['name']}]);
            }
            foreach ($group['documents'] as $document) {
                if (isset($document['inputs']) && count($document['inputs']) > 0) {
                    foreach ($document['inputs'] as $key => $input) {
                        if (isset($request->{$input['id']}) && $request->{$input['id']} != '') {
                            $uploadedDoc = TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->first();
                            //dd(TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->toSql(), TempDocument::where('model_name', config('applicationDocumentType.CONVERSION.TempModelName'))->where('model_id', $conversionId)->where('document_type', $document['id'])->getBindings());
                            if (empty($uploadedDoc)) {
                                return response()->json(['status' => 'error', 'message' => 'An error occurred while appliation upladed document not found']);
                            }
                            $docId = $uploadedDoc->id;
                            $updated = $this->storeTempDocKey($docId, $input['id'], $request->{$input['id']});
                            if (!$updated) {
                                return response()->json(['status' => 'error', 'message' => 'something went wrong in saving  the values of input fields']);
                            }
                        }
                    }
                }
            }

            $updated = $conversion->update(['consent' => $request->applicantConsent ? 1 : 0]);
            if ($updated) {
                $tempModelName = config('applicationDocumentType.CONVERSION.TempModelName');
                $encodedModelName = base64_encode($tempModelName);
                $encodedModelId = base64_encode($conversion->id);
                // redirect to payemnt page after data saved
                $redirectUrl = route('applicationPayment', [$encodedModelName, $encodedModelId]);
                // return redirect()->route('applicationPayment', [$encodedModelName, $encodedModelId]);
                return response()->json(['status' => 'success', 'url' => $redirectUrl]);
                /*$paymentComplete = GeneralFunctions::paymentComplete($conversion->id, $tempModelName);
                 if ($paymentComplete) {
                    $submitted = GeneralFunctions::convertTempAppToFinal($conversion->id, $tempModelName, $paymentComplete);
                    return $submitted;
                } */
            } else {
                return response()->json(['status' => 'error', 'message' => ('messages.general.error.tryAgain')]);
            }
        }
        return response()->json(['status' => 'success', 'message' => 'All files uploaded and data saved']);
        /* });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while conversion appliation submission'], 500);
        } */
    }
}
