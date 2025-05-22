<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConversionCharge;
use App\Models\Item;
use App\Models\PropertyMaster;
use App\Models\SplitedPropertyDetail;
use App\Services\ColonyService;
use App\Services\LandRateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversionController extends Controller
{
    public function calculateConversionCharges(ColonyService $colonyService)
    {
        $data = [];
        $user = Auth::user();
        if ($user->user_type == 'applicant') {
            $data['isApplicant'] = true;
            $data['properties'] = $user->userProperties;
        } else {
            $data['colonies'] = $colonyService->misDoneForColonies();
        }
        return view('calculation.conversion', $data);
    }

    public function chargesForProperty(Request $request)
    {
        $propertyId = $request->propertyId;
        $lesseeType = $request->lesseType;
        if ($propertyId != "") {
            $colonyId = $propertyTypeName = $propertyType = $area = "";
            if (strpos($propertyId, '_')) {
                $id_arr = explode('_', $propertyId);
                $masterPropertyId = $id_arr[0];
                $childPropertyId = $id_arr[1];
                if ($masterPropertyId != "" && $childPropertyId != "") {
                    $masterProperty = PropertyMaster::find($masterPropertyId);
                    $childProperty = SplitedPropertyDetail::find($childPropertyId);
                    if (!empty($masterProperty) && !empty($childProperty)) {
                        $old_property_id = $childProperty->old_property_id;
                        $allowAccess = userHasAccessToProperty($old_property_id);

                        if (!$allowAccess) {
                            return response()->json(['status' => 'error', 'details' => config('messages.property.error.accessDenied')]);
                        }
                        if ($childProperty->property_status != '951') {
                            return response()->json(['status' => 'error', 'details' => 'Please select lease hold property']);
                        }
                        $colonyId = $masterProperty->old_colony_name;
                        $propertyType = $masterProperty->property_type;
                        $propertyTypeName = $masterProperty->propertyTypeName;
                        $area = $childProperty->area_in_sqm;
                    } else {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.invalidId')]);
                    }
                } else {
                    return response()->json(['status' => 'error', 'details' => config('messages.property.error.invalidId')]);
                }
            } else {
                $masterProperty = PropertyMaster::where('old_propert_id', $propertyId)->first();
                if (empty($masterProperty)) {
                    $childProperty = SplitedPropertyDetail::where('old_property_id', $propertyId)->first();
                    if (empty($childProperty)) {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.invalidId')]);
                    }
                    $allowAccess = userHasAccessToProperty($childProperty->old_property_id);

                    if (!$allowAccess) {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.accessDenied')]);
                    }

                    if ($childProperty->property_status != '951') {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.notLeaseHold')]);
                    }
                    $masterPropertyId = $childProperty->property_master_id;
                    $masterProperty = PropertyMaster::find($masterPropertyId);
                    $colonyId = $masterProperty->old_colony_name;
                    $propertyType = $masterProperty->property_type;
                    $propertyTypeName = $masterProperty->propertyTypeName;
                    $area = $childProperty->area_in_sqm;
                } else {
                    $allowAccess = userHasAccessToProperty($propertyId);

                    if (!$allowAccess) {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.accessDenied')]);
                    }

                    if ($masterProperty->status != '951') {
                        return response()->json(['status' => 'error', 'details' => config('messages.property.error.notLeaseHold')]);
                    }
                    $colonyId = $masterProperty->old_colony_name;
                    $propertyType = $masterProperty->property_type;
                    $propertyTypeName = $masterProperty->propertyTypeName;
                    $area = $masterProperty->propertyLeaseDetail->plot_area_in_sqm;
                }
            }
            if (!isset($area) || $area <= 0) {
                return response()->json(['status' => 'error', 'details' => config('messages.property.error.invalidArea')]);
            }
            $landRateType = config('constants.conversion_calculation_rate');
            // Config::get();
            $landRateService = new LandRateService();
            $landRateRow = $landRateService->getLandRates($landRateType, $propertyTypeName, $colonyId, date('Y-m-d'));
            if (isset($landRateRow['error'])) {
                return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.dataNotAvailable')]);
            }
            if (empty($landRateRow)) {
                return response()->json(['status' => 'error', 'details' => config('messages.property.error.landRateNotFound')]);
            }
            $landRate = $landRateRow->land_rate;
            $conversionFormula = $this->getConversionFormula($propertyType, $area);
            if ($conversionFormula == 0) {
                $conversionCharges = 0;
                $additionalCharges = 0;
                $total = 0;
                $conversionFormula = '0 as area < 50 Sqm.';
            } else {
                $equation = str_replace(['P', 'R'], [$area, $landRate], $conversionFormula);
                $conversionCharges = eval("return $equation;");
                $additionalCharges = $lesseeType == 1 ? 0.40 * $conversionCharges : 0.3333 * $conversionCharges;
                $total = $lesseeType == 1 ? 0.60 * $conversionCharges : 1.3333 * $conversionCharges;
            }
            return response()->json([
                'status' => 'success',
                'propertyId' => isset($childProperty) ? $childProperty->old_peroperty_id : $masterProperty->old_propert_id,
                'colonyName' => $masterProperty->oldColony->name,
                'propertyArea' => $area,
                'landRate' => $landRate,
                'formula' => str_replace(['P', 'R', '*'], ['Plot Area', 'Land Rate', '&times;'], $conversionFormula),
                'equation' => isset($equation) ? str_replace('*', '&times;', $equation) : 0,
                'charges' => customNumFormat(round($conversionCharges, 2)),
                "propertyType" => $masterProperty->propertyTypeName,
                "propertySubtype" => $masterProperty->propertySubtypeName,
                "additionalChargesLabel" => $lesseeType == 1 ? 'Remission for Recorded Lessee' : 'Additional charges',
                'additionalCharges' =>  customNumFormat(round($additionalCharges, 2)),
                'additionalFormula' =>  $lesseeType == 1 ? '40% of Conversion Charges' : '33.33% of Conversion Charges',
                'total' =>  customNumFormat(round($total, 2))
            ]);
        } else {
            return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.invalidId')]);
        }
    }

    private function getConversionFormula($propertyType, $area)
    {
        $row = ConversionCharge::where('property_type', $propertyType)->where(function ($query) use ($area) {
            $query->whereNull('area_from')->orWhere(function ($q) use ($area) {
                $q->where('area_from', '<', $area)->where(function ($q1) use ($area) {
                    $q1->where('area_to', '>=', $area)->orWhereNull('area_to');
                });
            });
        })->first();
        if (empty($row)) {
            return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.dataNotAvailable')]);
        }
        return $row->formula;
    }
}
