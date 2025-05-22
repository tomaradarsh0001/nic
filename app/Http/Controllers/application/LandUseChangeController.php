<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Models\LandUseChangeMatrix;
use App\Models\TempDocument;
use App\Models\TempLandUseChangeApplication;
use App\Services\PropertyMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\GeneralFunctions;

class LandUseChangeController extends Controller
{
    public function fetchLandUseChangeDetails(Request $request)
    {
        $propertyId = $request->propertyId;
        $pms = new PropertyMasterService();
        $properties = $pms->propertyFromSelected($propertyId);
        if ($properties['status'] == 'error') {
            return response()->json($properties);
        }
        $childProperty = $properties['childProperty'] ?? null;
        $masterProperty = $properties['masterProperty'];
        $propertyStatus = !is_null($childProperty) ? $childProperty->property_status : $masterProperty->status;
        if ($propertyStatus != 951) {
            return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.notLeaseHoldProperty')]);
        }
        $area = !is_null($childProperty) ? $childProperty->area_in_sqm : $masterProperty->propertyLeaseDetail->plot_area_in_sqm;
        $known_as = !is_null($childProperty) ? $childProperty->presently_kown_as : $masterProperty->propertyLeaseDetail->presently_known_as;
        $propertyType = $masterProperty->property_type;
        $propertySubtype = $masterProperty->property_sub_type;
        $lcm = new LandUseChangeMatrix();
        $allowdChnage = $lcm->getAllowedOptions($propertyType, $propertySubtype);
        if ($request->updateId == 0) {
            $query = TempLandUseChangeApplication::where('property_master_id', $masterProperty->id);
            if (!is_null($childProperty)) {
                $query = $query->where('splited_property_detail_id', $childProperty->id);
            } else {
                $query = $query->whereNull('splited_property_detail_id');
            }
            $oldData = $query->first();

            //this code should be uncommented in production
            /* if (!empty($oldData)) {
                return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.applicationAlreadyExist')]);
            } */
        }

        return [
            'status' => 'success',
            'colony_id' => $masterProperty->old_colony_name,
            'colony_name' => $masterProperty->oldColony->name,
            'block_no' => $masterProperty->block_no,
            'plot_no' => !is_null($childProperty) ? $childProperty->plot_flat_no : $masterProperty->plot_or_property_no,
            'known_as' => $known_as,
            'area' => round($area, 2),
            'lease_type' => $masterProperty->propertyLeaseDetail->leaseTypeName,
            'allowdChnage' => $allowdChnage
        ];
    }

    public function step1Submit(Request $request, PropertyMasterService $pms)
    {
        try {
            return
                DB::transaction(function () use ($request, $pms) {
                    $propertyId = $request->oldPropertyId;
                    $lucId = $request->id ?? null;
                    if ($propertyId) {
                        $properties = $pms->propertyFromSelected($propertyId);
                        if ($properties['status'] == 'error') {
                            return response()->json($properties);
                        }
                        $masterProperty = $properties['masterProperty'];
                        $childProperty = isset($properties['childProperty']) ? $properties['childProperty'] : null;
                        $splitedId = !is_null($childProperty) ? $childProperty->id : null;

                        if ($lucId == 0) {
                            $recordExists = TempLandUseChangeApplication::where('property_master_id', $masterProperty->id)->where(function ($query) use ($childProperty) {
                                if (is_null($childProperty))
                                    return $query->whereNull('splited_property_detail_id');
                                else
                                    return $query->where('splited_property_detail_id', $childProperty->id);
                            })->exists();
                            if ($recordExists) {
                                //    return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.applicationAlreadyExist')]);
                            }
                        }

                        $tempRecord = TempLandUseChangeApplication::updateOrCreate(['id' => $lucId], [
                            'old_property_id' => $propertyId,
                            'property_master_id' => $masterProperty->id,
                            'new_property_id' => !is_null($childProperty) ? $childProperty->child_prop_id : $masterProperty->unique_propert_id,
                            'splited_property_detail_id' => $splitedId,
                            'property_type_change_from' => $request->propertyTypeFrom,
                            'property_subtype_change_from' => $request->propertySubtypeFrom,
                            'property_type_change_to' => $request->propertyTypeTo,
                            'property_subtype_change_to' => $request->propertySubtypeTo,
                            'applicant_status' => $request->applicantStatus,
                            'created_by' => Auth::id(),
                            'updated_by'  => Auth::id(),
                        ]);

                        if ($tempRecord) {
                            return response()->json([
                                'status' => 'success',
                                'id' => $tempRecord->id,
                                'message' => config('messages.general.success.create')
                            ]);
                        } else {
                            return response()->json(['status' => 'error', 'details' => config('messages.general.error.unknown')]);
                        }
                    } else {
                        return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.propertyIdMissing')]);
                    }
                });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'details' => config('messages.general.error.unknown'), 'error' => $e->errorInfo[2] ?? $e->getMessage()], 500);
        }
    }

    public function step2Submit(Request $request)
    {
        $id = $request->id;

        $documenList = config('applicationDocumentType.LUC.documents');
        $requiredDocuments = collect($documenList)->where('required', 1)->all();
        $requiredDocumentTypes = array_map(function ($element) {
            return $element['id']; //'label'
        }, $requiredDocuments);
        $uploadedDocuments = TempDocument::where('model_name', 'TempLandUseChangeApplication')->where('model_id', $id)->pluck('document_type')->toArray();
        $allRequiredDocsUploaded = true;
        $missing = [];
        foreach ($requiredDocumentTypes as $key => $doc) {
            if (!in_array($doc, $uploadedDocuments)) {
                $allRequiredDocsUploaded = false;
                $missing[] = $requiredDocuments[$key];
            }
        }
        if ($allRequiredDocsUploaded) {
            $consent = $request->consent;
            if ($consent != 1) {
                return response()->json(['status' => 'error', 'message' => config('messages.landUseChange.error.terms')]);
            }
            $updated = TempLandUseChangeApplication::where('id', $id)->update([
                'applicant_consent' => 1
            ]);
            if ($updated) {
                $tempModelName = config('applicationDocumentType.LUC.TempModelName');
                $encodedModelName = base64_encode($tempModelName);
                $encodedModelId = base64_encode($request->id);
                // redirect to payemnt page after data saved
                $redirectUrl = route('applicationPayment', [$encodedModelName, $encodedModelId]);
                // return redirect()->route('applicationPayment', [$encodedModelName, $encodedModelId]);
                return response()->json(['status' => 'success', 'url' => $redirectUrl]);
                /* $paymentComplete = GeneralFunctions::paymentComplete($request->id, $tempModelName);
                if ($paymentComplete) {
                    $submitted = GeneralFunctions::convertTempAppToFinal($request->id, $tempModelName, $paymentComplete);

                    return $submitted;
                } */
            } else {
                return response()->json(['status' => 'error', 'message' => ('messages.general.error.tryAgain')]);
            }
        } else {
            return response()->json(['status' => 'error', 'missing' => $missing]);
        }
    }

    // not used after last update

    /* public function step3Submit(Request $request)
    {
        $id = $request->id;
        $consent = $request->consent;
        if ($consent != 1) {
            return response()->json(['status' => 'error', 'message' => config('messages.landUseChange.error.terms')]);
        } else {
            $updated = TempLandUseChangeApplication::where('id', $id)->update([
                'applicant_consent' => 1
            ]);
            if ($updated) {
                $tempModelName = config('applicationDocumentType.LUC.TempModelName');
                $paymentComplete = GeneralFunctions::paymentComplete($request, $tempModelName);
                if ($paymentComplete) {
                    GeneralFunctions::convertTempAppToFinal($request->updateId, $tempModelName);
                    $response = ['status' => true, 'message' => 'Mutation application submitted Successfully'];
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try after sometime']);
            }
        }
    } */
}