<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempSubstitutionMutation;
use App\Models\TempCoapplicant;
use App\Models\PropertyMaster;
use App\Models\TempDocument;
use App\Services\PropertyMasterService;
use App\Models\TempDocumentKey;
use App\Models\Payment;
use App\Models\OldColony;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Helpers\GeneralFunctions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MutationContoller extends Controller
{
    // for storing mutation step first data - Sourav Chauhan (17/sep/2024)
 /* public function mutationStepFirst(Request $request)
    {
        // dd($request->all());
        //document values validation - SOURAV CHAUHAN (7/oct/2024)
        $messages = [
            'statusofapplicant.required' => 'Please select the applicant status',
            'mutNameAsConLease.required' => 'Executed in favour of is required',
            'mutExecutedOnAsConLease.required' => 'Executed on is required',
            'mutRegnoAsConLease.required' => 'Regn. No. is required',
            'mutBooknoAsConLease.required' => 'Book No. is required',
            'mutVolumenoAsConLease.required' => 'Volume No. is required',
            'mutPagenoFrom.required' => 'Page No. From is required',
            'mutPagenoTo.required' => 'Page No. To is required',
            'mutRegdateAsConLease.required' => 'Regn. Date. is required',
            'soughtByApplicantDocuments.required' => 'Sought by applicant document is required',
        ];

        $validator = Validator::make($request->all(), [
            'statusofapplicant' => 'required',
            'mutNameAsConLease' => 'required',
            'mutExecutedOnAsConLease' => 'required',
            'mutRegnoAsConLease' => 'required',
            'mutBooknoAsConLease' => 'required',
            'mutVolumenoAsConLease' => 'required',
            'mutPagenoFrom' => 'required',
            'mutPagenoTo' => 'required',
            'mutRegdateAsConLease' => 'required',
            'soughtByApplicantDocuments' => 'required'
        ], $messages);

        if ($validator->fails()) {
            // Log the error message if validation fails
            Log::info("| " . Auth::user()->email . " | Mutation step first all values not entered: " . json_encode($validator->errors()));
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        // try {
            return DB::transaction(function () use ($request) {
                $tempSubstitutionMutation = null;
                $updateId = $request->updateId;
                if ($request->propertyStatus == 'Free Hold') {
                    $propertyStatus = 952;
                } else {
                    $propertyStatus = 951;
                }
                if ($updateId != '0') {
                    // dd($request->all());
                    $tempSubstitutionMutation = TempSubstitutionMutation::find($updateId);
                    if (isset($tempSubstitutionMutation)) {
                        $soughtByApplicantDocuments = explode(",",$request->soughtByApplicantDocuments);
                        $tempSubstitutionMutation->property_status = $propertyStatus;
                        $tempSubstitutionMutation->status_of_applicant = $request->statusofapplicant;
                        $tempSubstitutionMutation->name_as_per_lease_conv_deed = $request->mutNameAsConLease;
                        $tempSubstitutionMutation->executed_on = $request->mutExecutedOnAsConLease;
                        $tempSubstitutionMutation->reg_no_as_per_lease_conv_deed = $request->mutRegnoAsConLease;
                        $tempSubstitutionMutation->book_no_as_per_lease_conv_deed = $request->mutBooknoAsConLease;
                        $tempSubstitutionMutation->volume_no_as_per_lease_conv_deed = $request->mutVolumenoAsConLease;
                        $tempSubstitutionMutation->page_no_as_per_deed = $request->mutPagenoFrom.'-'.$request->mutPagenoTo;
                        $tempSubstitutionMutation->reg_date_as_per_lease_conv_deed = $request->mutRegdateAsConLease;
                        $tempSubstitutionMutation->sought_on_basis_of_documents = json_encode($soughtByApplicantDocuments);
                        $tempSubstitutionMutation->property_stands_mortgaged = $request->mutPropertyMortgaged;
                        $tempSubstitutionMutation->mortgaged_remark = ($request->mutPropertyMortgaged == 1) ? $request->mutMortgagedRemarks : NULL;
                        // $tempSubstitutionMutation->is_basis_of_court_order = $request->mutCourtorder;
                        // if (isset($request->mutCourtorder)) {
                        //     $tempSubstitutionMutation->court_case_no = $request->mutCaseNo;
                        //     $tempSubstitutionMutation->court_case_details = $request->mutCaseDetail;
                        // } else {
                        //     $tempSubstitutionMutation->court_case_no = null;
                        //     $tempSubstitutionMutation->court_case_details = null;
                        // }
                        $tempSubstitutionMutation->updated_by = Auth::user()->id;
                        if ($tempSubstitutionMutation->save()) {
                            $modelId = $tempSubstitutionMutation->id;
                            // $stepOneSubmit = $this->updateTempCoApplicants($request->coapplicant, $modelId,$tempSubstitutionMutation->old_property_id);
                            // if ($stepOneSubmit) {
                            $stepOneSubmit = $this->updateTempCoApplicants($request->coapplicant, $modelId,$tempSubstitutionMutation->old_property_id);
                            $data = ['tempSubstitutionMutation' => $tempSubstitutionMutation,'ids' => $stepOneSubmit['ids']];
                            if ($stepOneSubmit['allSaved']) {
                                $response = ['status' => true, 'message' => 'Property Details Updated Successfully', 'data' => $data];
                            } else {
                                $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
                            }
                        } else {
                            $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
                        }
                    } else {
                        $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
                    }
                } else {
                    $propertyDetails = PropertyMaster::where('old_propert_id', $request->propertyid)->first();
                    $soughtByApplicantDocuments = explode(",",$request->soughtByApplicantDocuments);
                    $tempSubstitutionMutation = TempSubstitutionMutation::create([
                        'old_property_id' => $request->propertyid,
                        'new_property_id' => $propertyDetails['unique_propert_id'],
                        'property_master_id' => $propertyDetails['id'],
                        'property_status' => $propertyStatus,
                        'status_of_applicant' => $request->statusofapplicant,
                        'name_as_per_lease_conv_deed' => $request->mutNameAsConLease,
                        'executed_on' => $request->mutExecutedOnAsConLease,
                        'reg_no_as_per_lease_conv_deed' => $request->mutRegnoAsConLease,
                        'book_no_as_per_lease_conv_deed' => $request->mutBooknoAsConLease,
                        'volume_no_as_per_lease_conv_deed' => $request->mutVolumenoAsConLease,
                        'page_no_as_per_deed' => $request->mutPagenoFrom.'-'.$request->mutPagenoTo,
                        'reg_date_as_per_lease_conv_deed' => $request->mutRegdateAsConLease,
                        'sought_on_basis_of_documents' => json_encode($soughtByApplicantDocuments),
                        'property_stands_mortgaged' => $request->mutPropertyMortgaged,
                        'mortgaged_remark' => ($request->mutPropertyMortgaged == 1) ? $request->mutMortgagedRemarks : NULL,
                        // 'is_basis_of_court_order' => $request->mutCourtorder,
                        // 'court_case_no' => $request->mutCaseNo,
                        // 'court_case_details' => $request->mutCaseDetail,
                        'created_by' => Auth::user()->id,
                    ]);
                    if ($tempSubstitutionMutation) {
                        $modelId = $tempSubstitutionMutation->id;
                        // $stepOneSubmit = $this->storeTempCoApplicants($request->coapplicant, $modelId,$request->propertyid);
                        // if ($stepOneSubmit) {
                        $stepOneSubmit = $this->storeTempCoApplicants($request->coapplicant, $modelId,$request->propertyid);
                        $data = ['tempSubstitutionMutation' => $tempSubstitutionMutation,'ids' => $stepOneSubmit['ids']];
                        if ($stepOneSubmit['allSaved']) {
                            $response = ['status' => true, 'message' => 'Property Details Saved Successfully', 'data' => $data];
                        } else {
                            $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
                        }
                    } else {
                        $response = ['status' => false, 'message' => 'Something went wrong!', 'data' => 0];
                    }
                }
                return json_encode($response);
            });
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        //     return response()->json(['status' => false, 'message' => 'An error occurred while mutation appliation submission'], 500);
        // }
    }

*/


    public function mutationStepFirst(Request $request, PropertyMasterService $propertyMasterService)
    {
        // dd($request->all());
        //document values validation - SOURAV CHAUHAN (7/oct/2024)
        $messages = [
            'statusofapplicant.required' => 'Please select the applicant status',
            'mutNameAsConLease.required' => 'Executed in favour of is required',
            'mutExecutedOnAsConLease.required' => 'Executed on is required',
            'mutRegnoAsConLease.required' => 'Regn. No. is required',
            'mutBooknoAsConLease.required' => 'Book No. is required',
            'mutVolumenoAsConLease.required' => 'Volume No. is required',
            'mutPagenoFrom.required' => 'Page No. From is required',
            'mutPagenoTo.required' => 'Page No. To is required',
            'mutRegdateAsConLease.required' => 'Regn. Date. is required',
            'soughtByApplicantDocuments.required' => 'Sought by applicant document is required',
        ];

        $validator = Validator::make($request->all(), [
            'statusofapplicant' => 'required',
            'mutNameAsConLease' => 'required',
            'mutExecutedOnAsConLease' => 'required',
            'mutRegnoAsConLease' => 'required',
            'mutBooknoAsConLease' => 'required',
            'mutVolumenoAsConLease' => 'required',
            'mutPagenoFrom' => 'required',
            'mutPagenoTo' => 'required',
            'mutRegdateAsConLease' => 'required',
            'soughtByApplicantDocuments' => 'required'
        ], $messages);

        if ($validator->fails()) {
            // Log the error message if validation fails
            Log::info("| " . Auth::user()->email . " | Mutation step first all values not entered: " . json_encode($validator->errors()));
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        // dd($request->coapplicant);
        // try {

        return DB::transaction(function () use ($request, $propertyMasterService) {
            $tempSubstitutionMutation = null;
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

            $soughtByApplicantDocuments = explode(",",$request->soughtByApplicantDocuments);
            $tempSubstitutionMutation = TempSubstitutionMutation::updateOrCreate(
                ['id' => $updateId],
                [
                    'old_property_id' => $request->propertyid,
                    'new_property_id' => $masterProperty->unique_propert_id,
                    'property_master_id' => $masterProperty->id,
                    'property_status' => $propertyStatus,
                    'status_of_applicant' => $request->statusofapplicant,
                    'name_as_per_lease_conv_deed' => $request->mutNameAsConLease,
                    'executed_on' => $request->mutExecutedOnAsConLease,
                    'reg_no_as_per_lease_conv_deed' => $request->mutRegnoAsConLease,
                    'book_no_as_per_lease_conv_deed' => $request->mutBooknoAsConLease,
                    'volume_no_as_per_lease_conv_deed' => $request->mutVolumenoAsConLease,
                    'page_no_as_per_deed' => $request->mutPagenoFrom.'-'.$request->mutPagenoTo,
                    'reg_date_as_per_lease_conv_deed' => $request->mutRegdateAsConLease,
                    'sought_on_basis_of_documents' => json_encode($soughtByApplicantDocuments),
                    'property_stands_mortgaged' => $request->mutPropertyMortgaged,
                    'mortgaged_remark' => ($request->mutPropertyMortgaged == 1) ? $request->mutMortgagedRemarks : NULL,
                    'updated_by' => Auth::id(),
                ]
            );
            if ($tempSubstitutionMutation->wasRecentlyCreated) {
                $tempSubstitutionMutation->created_by = Auth::id();
                $tempSubstitutionMutation->save();
            }

            $modelName = 'TempSubstitutionMutation';
            $modelId = $tempSubstitutionMutation->id;
            $serviceType = 'SUB_MUT';
            $stepOneSubmit = GeneralFunctions::storeTempCoApplicants($serviceType, $modelName, $modelId, $masterProperty->newColony->code, $request);
            if ($stepOneSubmit) {
                return response()->json(['status' => 'success', 'message' => 'Property Details Saved Successfully', 'data' => $tempSubstitutionMutation]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong!', 'data' => 0]);
            }
        });
           
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        //     return response()->json(['status' => false, 'message' => 'An error occurred while mutation appliation submission'], 500);
        // }
    }

    //for storing temp co Applicants - Sourav Chauhan (17/sep/2024)
    protected function storeTempCoApplicants($coapplicants, $modelId,$propertyId)
    {
        // dd($coapplicants);
        try {
            $allSaved = true;
            $ids = [];
            $data = [];
            foreach ($coapplicants as $key => $coapplicant) {
                if (!empty($coapplicant['name'])) {
                    $user = Auth::user();
                    $name = $coapplicant['name'].'_CO_'.$key+1;

                    $applicantNo = $user->applicantUserDetails->applicant_number;

                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                    $colonyId = $propertyDetails['new_colony_name'];
                    $colony = OldColony::find($colonyId);
                    $colonyCode = $colony->code;

                    $type = 'mutation';
                    $updateId = $modelId;

                    //coapplicant image
                    $photo = $coapplicant['photo'];
                    $date = now()->format('YmdHis');
                    $fileName =  $name . '_' . $date . '.' . $photo->extension();
                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                    $photo = $photo->storeAs($pathToUpload, $fileName, 'public');

                    //coapplicant aadhaarFile
                    $aadharnumber = $coapplicant['aadharnumber'];
                    $aadhaarFile = $coapplicant['aadhaarFile'];
                    $date = now()->format('YmdHis');
                    $fileName =  $aadharnumber . '_' . $date . '.' . $aadhaarFile->extension();
                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                    $aadharFile = $aadhaarFile->storeAs($pathToUpload, $fileName, 'public');
                    
                    //coapplicant panFile
                    $pannumber = $coapplicant['pannumber'];
                    $panFile = $coapplicant['panFile'];
                    $date = now()->format('YmdHis');
                    $fileName =  $pannumber . '_' . $date . '.' . $panFile->extension();
                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                    $panFile = $panFile->storeAs($pathToUpload, $fileName, 'public');


                    $tempCoapplicant = TempCoapplicant::create([
                        'service_type' => getServiceType('SUB_MUT'),
                        'model_name' => 'TempSubstitutionMutation',
                        'index_no' => $coapplicant['indexNo'],
                        'model_id' => $modelId,
                        'co_applicant_name' => $coapplicant['name'],
                        'co_applicant_gender' => $coapplicant['gender'],
                        'co_applicant_age' => $coapplicant['dateOfBirth'],
                        'prefix' => $coapplicant['prefixInv'],
                        'co_applicant_father_name' => $coapplicant['secondnameInv'],
                        'co_applicant_aadhar' => $coapplicant['aadharnumber'],
                        'co_applicant_pan' => $coapplicant['pannumber'],
                        'co_applicant_mobile' => $coapplicant['mobilenumber'],
                        'image_path' => $photo,
                        'aadhaar_file_path' => $aadharFile,
                        'pan_file_path' => $panFile,
                        'created_by' => Auth::user()->id,
                    ]);
                    if (!$tempCoapplicant) {
                        $allSaved = false;
                    } else {
                        $id = $tempCoapplicant->id;
                        $ids[] = $id;
                    }
                }
            }
            $data = ['allSaved'=>$allSaved,'ids'=>$ids];
            return $data;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while while storing Coapplicants', 'error' => $e->getMessage()], 500);
        }
    }

    //for storing temp co Applicants - Sourav Chauhan (17/sep/2024)
    protected function updateTempCoApplicants($coapplicants, $modelId,$propertyId)
    {
        // dd($coapplicants);
        // try {
            $allSaved = true;
            $ids = [];
            $data = [];
            // $delCooapplicant = TempCoapplicant::where('model_id', $modelId)
            //     ->where('model_name', 'TempSubstitutionMutation')
            //     ->delete();
            // dd($coapplicants);
            foreach ($coapplicants as $key => $coapplicant) {
                if (!empty($coapplicant['name'])) {

                    $user = Auth::user();
                    $name = $coapplicant['name'].'_CO_'.$key+1;

                    $applicantNo = $user->applicantUserDetails->applicant_number;

                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                    $colonyId = $propertyDetails['new_colony_name'];
                    $colony = OldColony::find($colonyId);
                    $colonyCode = $colony->code;

                    $type = 'mutation';
                    $updateId = $modelId;
                    // if (isset($coapplicant['id']) || !is_null($coapplicant['undefined'])) {
                        if (isset($coapplicant['id']) || (isset($coapplicant['undefined']) && !is_null($coapplicant['undefined']))) {

                        if(isset($coapplicant['id'])){
                            $coapplicantId = $coapplicant['id'];
                        } else {
                            $coapplicantId = $coapplicant['undefined'];
                        }
                        if(!is_null($coapplicantId)){//for edit coapplicant
                            $tempCoapplicant = TempCoapplicant::find($coapplicantId);
    
                            //coapplicant image
                            if(isset($coapplicant['photo']) && $coapplicant['photo']){
                                $photo = $coapplicant['photo'];
                                $date = now()->format('YmdHis');
                                $fileName =  $name . '_' . $date . '.' . $photo->extension();
                                $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                                $photo = $photo->storeAs($pathToUpload, $fileName, 'public');
                            } else {
                                $photo = $tempCoapplicant->image_path;
                            }
    
                            //coapplicant aadhaarFile
                            $aadharnumber = $coapplicant['aadharnumber'];
                            if(isset($coapplicant['aadhaarFile']) && $coapplicant['aadhaarFile']){
                                $aadhaarFile = $coapplicant['aadhaarFile'];
                                $date = now()->format('YmdHis');
                                $fileName =  $aadharnumber . '_' . $date . '.' . $aadhaarFile->extension();
                                $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                                $aadharFile = $aadhaarFile->storeAs($pathToUpload, $fileName, 'public');
                            } else {
                                $aadharFile = $tempCoapplicant->aadhaar_file_path;
                            }
    
                            //coapplicant panFile
                            $pannumber = $coapplicant['pannumber'];
                            if(isset($coapplicant['panFile']) && $coapplicant['panFile']){
                                $panFile = $coapplicant['panFile'];
                                $date = now()->format('YmdHis');
                                $fileName =  $pannumber . '_' . $date . '.' . $panFile->extension();
                                $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                                $panFile = $panFile->storeAs($pathToUpload, $fileName, 'public');
                            } else {
                                $panFile = $tempCoapplicant->pan_file_path;
                            }
    
                            $tempCoapplicant->co_applicant_name = $coapplicant['name'];
                            $tempCoapplicant->co_applicant_gender = $coapplicant['gender'];

                            $tempCoapplicant->co_applicant_age = $coapplicant['dateOfBirth'];
                            $tempCoapplicant->prefix = $coapplicant['prefixInv'];
                            $tempCoapplicant->co_applicant_father_name = $coapplicant['secondnameInv'];
                            $tempCoapplicant->co_applicant_aadhar = $coapplicant['aadharnumber'];
                            $tempCoapplicant->co_applicant_pan = $coapplicant['pannumber'];
                            $tempCoapplicant->co_applicant_mobile = $coapplicant['mobilenumber'];
                            $tempCoapplicant->image_path = $photo;
                            $tempCoapplicant->aadhaar_file_path = $aadharFile;
                            $tempCoapplicant->pan_file_path = $panFile;
                            $tempCoapplicant->save();
    
                        }
                    } else {//for create coapplicant
                        //coapplicant image
                        if($coapplicant['photo']){
                            $photo = $coapplicant['photo'];
                            $date = now()->format('YmdHis');
                            $fileName =  $name . '_' . $date . '.' . $photo->extension();
                            $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                            $photo = $photo->storeAs($pathToUpload, $fileName, 'public');
                        }

                        //coapplicant aadhaarFile
                        $aadharnumber = $coapplicant['aadharnumber'];
                        if($coapplicant['aadhaarFile']){
                            $aadhaarFile = $coapplicant['aadhaarFile'];
                            $date = now()->format('YmdHis');
                            $fileName =  $aadharnumber . '_' . $date . '.' . $aadhaarFile->extension();
                            $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                            $aadharFile = $aadhaarFile->storeAs($pathToUpload, $fileName, 'public');
                        }

                        //coapplicant panFile
                        $pannumber = $coapplicant['pannumber'];
                        if($coapplicant['panFile']){
                            $panFile = $coapplicant['panFile'];
                            $date = now()->format('YmdHis');
                            $fileName =  $pannumber . '_' . $date . '.' . $panFile->extension();
                            $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId.'/co-applicants/co-'.$key+1;
                            $panFile = $panFile->storeAs($pathToUpload, $fileName, 'public');
                        }

                        // dd('doc uploaded');
                        $tempCoapplicant = TempCoapplicant::create([
                            'service_type' => getServiceType('SUB_MUT'),
                            'model_name' => 'TempSubstitutionMutation',
                            'index_no' => $coapplicant['indexNo'],
                            'model_id' => $modelId,
                            'co_applicant_name' => $coapplicant['name'],
                            'co_applicant_gender' => $coapplicant['gender'],
                            'co_applicant_age' => $coapplicant['dateOfBirth'],
                            'prefix' => $coapplicant['prefixInv'],
                            'co_applicant_father_name' => $coapplicant['secondnameInv'],
                            'co_applicant_aadhar' => $coapplicant['aadharnumber'],
                            'co_applicant_pan' => $coapplicant['pannumber'],
                            'co_applicant_mobile' => $coapplicant['mobilenumber'],
                            'image_path' => $photo,
                            'aadhaar_file_path' => $aadharFile,
                            'pan_file_path' => $panFile,
                            'created_by' => Auth::user()->id,
                        ]);
                    }
                   
                    if (!$tempCoapplicant) {
                        $allSaved = false;
                    } else {
                        $id = $tempCoapplicant->id;
                        $ids[] = $id;
                    }
                }
            }
            $data = ['allSaved'=>$allSaved,'ids'=>$ids];
            return $data;
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        //     return response()->json(['status' => false, 'message' => 'An error occurred while storing Coapplicants', 'error' => $e->getMessage()], 500);
        // }
    }


    // for storing mutation step second documents data - Sourav Chauhan (17/sep/2024)
    public function mutationStepSecond(Request $request)
    {

        // dd($request->all());
        //documents validation - SOURAV CHAUHAN (7/oct/2024)
        $documentsRequired = config('applicationDocumentType.MUTATION.Required');
        $serviceType = getServiceType('SUB_MUT');
        // foreach ($documentsRequired as $document) {
        //     $isDocUploaded = TempDocument::where('service_type', $serviceType)->where('model_id', $request->updateId)->where('document_type', $document)->first();
        //     if (empty($isDocUploaded)) {
        //         Log::info("| " . Auth::user()->email . " | Mutation step second all documents not uploaded");
        //         return response()->json(['status' => false, 'message' => 'Please provide all required documents.']);
        //     }
        // }


        //document values validation - SOURAV CHAUHAN (7/oct/2024)
        $validator = Validator::make($request->all(), [
            'affidavits' => 'required|array',
            'affidavits.*.affidavitsDateOfAttestation' => 'required|date',
            'affidavits.*.affidavitAttestedBy' => 'required|string|max:255',
            'indemnityBond' => 'required|array',
            'indemnityBond.*.indemnityBondDateOfAttestation' => 'required|date',
            'indemnityBond.*.indemnityBondAttestedBy' => 'required|string|max:255',
            'newspaperNameEnglish' => 'required',
            'publicNoticeDateEnglish' => 'required',
            'newspaperNameHindi' => 'required',
            'publicNoticeDateHindi' => 'required',
        ]);

        if ($validator->fails()) {
            // Log the error message if validation fails
            Log::info("| " . Auth::user()->email . " | Mutation step second all documents keys not entered: " . json_encode($validator->errors()));
            return response()->json(['status' => false, 'message' => 'Please provide all required document values.']);
        }

        // dd('validaion true');
        // try {
            return DB::transaction(function () use ($request,$documentsRequired,$serviceType) {
                $appMutId = $request->updateId;
                if (isset($appMutId)) { //if hidden ID available
                    $isMutAppAvailable = TempSubstitutionMutation::where('id', $appMutId)->first();
                    if (!empty($isMutAppAvailable)) { //if mutation available for this ID
                        //for storing documents data
                        $doumentDataStored = $this->storeDataForDocuments($request, $serviceType, $documentsRequired);
                        if ($doumentDataStored['status']) {
                            $response = ['status' => true, 'message' => 'Property Documents Saved Successfully','data' => $doumentDataStored['savedDocumentIds']];
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
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        //     return response()->json(['status' => false, 'message' => 'An error occurred while storing appliation documents'], 500);
        // }
    }


    // for storing mutation step third documents data - Sourav Chauhan (20/sep/2024)
    //moved to general functions by Nitin Raghuvanshi - 07-10-2024
    public function mutationStepThird(Request $request)
    {
        // dd($request->all());
        //documents validation - SOURAV CHAUHAN (10/oct/2024)
        // $documentsOptional = config('applicationDocumentType.MUTATION.Optional');
        // foreach($documentsOptional as $key => $documents){
        //     $serviceType = getServiceType('SUB_MUT');
        //     $isDocUploaded = TempDocument::where('service_type',$serviceType)->where('model_id',$request->updateId)->where('document_type',$key)->first();
        //     if(!empty($isDocUploaded)){
        //         foreach($documents as $inputName => $document){
        //             if(empty($request->$inputName)){
        //                 Log::info("| " . Auth::user()->email . " | Mutation step three " .$key." documents value ".$inputName." not entered");
        //                 return response()->json(['status' => false, 'message' => 'Please provide all required values for '.$key.' .']);
        //             }
        //         }
        //     }
        // }

        //document validation according to the checked documents at step one
        $tempSubstitutionMutation = TempSubstitutionMutation::find($request->updateId);
        if (isset($tempSubstitutionMutation)) {
            $serviceType = getServiceType('SUB_MUT');
            $checkedDocuments = json_decode($tempSubstitutionMutation['sought_on_basis_of_documents']);
            foreach ($checkedDocuments as $checkedDocument) {
                $itemName = getServiceTypeColorCode($checkedDocument);
                $isDocUploaded = TempDocument::where('service_type', $serviceType)->where('model_id', $request->updateId)->where('document_type', $itemName)->first();
                if (empty($isDocUploaded)) {
                    Log::info("| " . Auth::user()->email . " | Mutation step three " . $checkedDocument . " documents not uploaded");
                    return response()->json(['status' => false, 'message' => 'Please provide all required documents']);
                } else {
                    $consent = $request->agreeConsent;
                    if ($consent != 1) {
                        return response()->json(['status' => false, 'message' => 'Please agree to terms & conditions']);
                    }
                }
            }
        }

        // try {
            return DB::transaction(function () use ($request) {
                $appMutId = $request->updateId;
                if (isset($appMutId)) { //if hidden ID available
                    $isMutAppAvailable = TempSubstitutionMutation::where('id', $appMutId)->first();
                    if (!empty($isMutAppAvailable)) { //if mutation available for this ID
                        $serviceType = getServiceType('SUB_MUT');
                        $applicationDocumentType = config('applicationDocumentType.MUTATION.Optional');

                            //for storing documents data
                            // $this->storeDataForDocuments($request,$serviceType,$applicationDocumentType);
                            $doumentDataStored = $this->storeDataForDocuments($request, $serviceType, $applicationDocumentType);
                            // dd($doumentDataStored);
                            // dd($request->agreeConsent);
                            $application = TempSubstitutionMutation::where('id',$appMutId)->first();
                            $application->undertaking = $request->agreeConsent;
                            if ($application->save()) {
                                $tempModelName = config('applicationDocumentType.MUTATION.TempModelName');
                                $paymentComplete = GeneralFunctions::paymentComplete($appMutId, $tempModelName);
                                // dd($paymentComplete);
                                if ($paymentComplete) {
                                    $transactionSuccess = true;
                                    //to convert temp application to final application - SOURAV CHAUHAN (1/Oct/2024)
                                    GeneralFunctions::convertTempAppToFinal($appMutId, $tempModelName,$paymentComplete);
                                    $response = ['status' => true, 'message' => 'Mutation application submitted Successfully'];
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
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        //     return response()->json(['status' => false, 'message' => 'An error occurred while storing application documents'], 500);
        // }
    }

    //payment completion - SOURAV CHAUHAN (1/oct/2024)


    //for storing documents data - SOURAV CHAUHAN (20/sep/2024)
    protected function storeDataForDocuments($request, $serviceType, $applicationDocumentType)
    {
        // dd($request->all(), $serviceType, $applicationDocumentType);
        $doumentDataStored = false;
        $savedDocumentIds = [];
        foreach ($applicationDocumentType as $index => $documentType) {
            $modelName = 'TempSubstitutionMutation';
            $serviceType = getServiceType('SUB_MUT');
            $updateId = $request->updateId;
            if ($documentType['multiple']) {
                // dd($request->{$documentType['id']});
                $count = 1;
                // dd($request->{$documentType['id']});
                foreach ($request->{$documentType['id']} as $documents) {
                    // dd($documents);
                    $docData = [];
                    if (is_array($documents)) {
                        $createDocument = $updateDocument = false;
                        // dd($documents,$documentType['id']);
                        foreach ($documents as $key => $document) {
                            // dd($document);
                            if (!array_key_exists($documentType['id'] . '_oldId', $documents)) {
                                $createDocument = true;
                            }
                            if($key == $documentType['id'] . '_oldId'){
                                if ($document === null) {
                                    //create document
                                    $createDocument = true;
                                } else {
                                    //update document
                                    if (array_key_exists($documentType['id'], $documents) && $documentType['id']) {
                                        // dd('inside else');
                                        $updateDocument = true;
                                        $updateDocumentId = $document;
                                    }
                                    
                                }

                            }

                            // dd($createDocument,$updateDocument,$document);
                            // dd($createDocument,$updateDocument);
                            if(is_file($document)){
                                //create new document
                                if($createDocument){
                                    // dd($createDocument,$document, 'Create',$key.'_'.$count);
                                    $user = Auth::user();
                                    $name = $key.'_'.$count;
                                    $applicantNo = $user->applicantUserDetails->applicant_number;
                                    $tempSubstitutionMutation = TempSubstitutionMutation::find($updateId);
                                    $propertyId = $tempSubstitutionMutation['old_property_id'];
                                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                                    $colonyId = $propertyDetails['new_colony_name'];
                                    $colony = OldColony::find($colonyId);
                                    $colonyCode = $colony->code;
                                    $type = 'mutation';

                                    //upload file
                                    $file = $document;
                                    $date = now()->format('YmdHis');
                                    $fileName =  $name . '_' . $date . '.' . $file->extension();
                                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId;
                                    $file = $file->storeAs($pathToUpload, $fileName, 'public');
                                    if($file){
                                        $documentUploded = TempDocument::create([
                                            'service_type' => $serviceType,
                                            'model_name' => $modelName, //'TempSubstitutionMutation',
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
                                if($updateDocument){
                                    $upoadedDocument = TempDocument::find($updateDocumentId);
                                    // dd($upoadedDocument);
                                    $user = Auth::user();
                                    $name = $key.'_'.$count;
                                    $applicantNo = $user->applicantUserDetails->applicant_number;
                                    $tempSubstitutionMutation = TempSubstitutionMutation::find($updateId);
                                    $propertyId = $tempSubstitutionMutation['old_property_id'];
                                    $propertyDetails = PropertyMaster::where('old_propert_id', $propertyId)->first();
                                    $colonyId = $propertyDetails['new_colony_name'];
                                    $colony = OldColony::find($colonyId);
                                    $colonyCode = $colony->code;
                                    $type = 'mutation';

                                    //upload file
                                    $file = $document;
                                    $date = now()->format('YmdHis');
                                    $fileName =  $name . '_' . $date . '.' . $file->extension();
                                    $pathToUpload = $applicantNo . '/' . $colonyCode . '/' . $type . '/' . $updateId;

                                    if(isset($upoadedDocument->file_path)){
                                        $deletedFile = $upoadedDocument->file_path;
                                        if ($deletedFile) {
                                            if (Storage::disk('public')->exists($deletedFile)) {
                                                Storage::disk('public')->delete($deletedFile);
                                            }
                                            $file = $file->storeAs($pathToUpload, $fileName, 'public');
                                            if($file){
                                                $upoadedDocument->file_path = $file;
                                                $upoadedDocument->updated_by = Auth::user()->id;
                                                $upoadedDocument->save();
                                            }
                                        }
                                    }
                                }
                            } else {
                                // dd($key);
                                if($key == $documentType['id']. '_oldId'){

                                } else {
                                    $docData[$key] = $document;
                                }
                                // dd('inside else');
                            }
                        }

                        //if document uploaded save the document values
                        if ($docData) {
                            $filteredData = array_filter($docData, function($value) {
                                return !is_null($value);
                            });
                            


                            // $arrayCount = count($filteredData);
                            // foreach ($docData as $k => $data) {
                            //     TempDocumentKey::updateOrCreate([
                            //         'temp_document_id' => $documentUploded->id,
                            //         'key' => $k
                            //     ], [
                            //         'value' => $data
                            //     ]);
                            // }
                            
                            // dd($filteredData);
                            $arrayCount = count($filteredData);
                            
                            if ($arrayCount > 2) {
                                // dd($filteredData);
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
                                // dd($filteredData);
                                foreach ($filteredData as $k => $data) {
                                    if(isset($documentUploded)){
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
                foreach($inputs as $input){
                    $id = $input['id'];
                    $label = $input['label'];
                    // dd($request->$id);
                    if($request->$id){
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




        // $firstLevelKeys = array_keys($applicationDocumentType);
        // foreach ($firstLevelKeys as $firstLevelKey) { //document
        //     $values = $applicationDocumentType[$firstLevelKey];
        //     foreach ($values as $key => $value) { //no of values
        //         $savedDocumentDetails = TempDocument::where('service_type', $serviceType)->where('model_id', $request->updateId)->where('document_type', $firstLevelKey)->first();
        //         if ($savedDocumentDetails) {
        //             $isDocumentValueAvailable = TempDocumentKey::where('temp_document_id', $savedDocumentDetails->id)->where('key', $key)->first();
        //             if (!empty($isDocumentValueAvailable)) {
        //                 $isDocumentValueAvailable->value = $request->$key;
        //                 $isDocumentValueAvailable->updated_by = Auth::user()->id;
        //                 $isDocumentValueAvailable->save();
        //             } else {
        //                 $tempDocumentKey = TempDocumentKey::create([
        //                     'temp_document_id' => $savedDocumentDetails->id,
        //                     'key' => $key,
        //                     'value' => $request->$key,
        //                     'created_by' => Auth::user()->id
        //                 ]);
        //             }
        //         }
        //     }
        // }
        $doumentDataStored = ['status'=>true,'savedDocumentIds'=>$savedDocumentIds];
        return $doumentDataStored;
    }
}
