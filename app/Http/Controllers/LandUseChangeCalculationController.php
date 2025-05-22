<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LandUseChangeMatrix;
use App\Services\ColonyService;
use App\Services\LandRateService;
use App\Services\PropertyMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LandUseChangeCalculationController extends Controller
{
    public function calculateLandUseChangeCharges(ColonyService $colonyService)
    {
        $data = [];
        $user = Auth::user();
        if ($user->user_type == 'applicant') {
            $data['isApplicant'] = true;
            $data['properties'] = $user->userProperties;
        } else {
            $data['colonies'] = $colonyService->misDoneForColonies();
        }
        return view('calculation.land-use-change', $data);
    }

    public function propertyTypeOptions($propertyId)
    {
        if ($propertyId != "") {
            $propertyMasterService = new PropertyMasterService();
            $propertyFromId = $propertyMasterService->propertyFromSelected($propertyId);
            if ($propertyFromId['status'] == 'error') {
                return response()->json($propertyFromId);
            } else {
                $masterProperty = $propertyFromId['masterProperty'];
                $childProperty = $propertyFromId['childProperty'] ?? null;
                if (!empty($masterProperty)) {
                    $propertyType = $masterProperty->property_type;
                    $propertySubtype = $masterProperty->property_sub_type;
                    $lcm = new LandUseChangeMatrix();
                    $matrixFilteredData = $lcm->getAllowedOptions($propertyType, $propertySubtype);

                    $landRateService = new LandRateService();
                    $landRateRow = $landRateService->getLandRates(config('constants.conversion_calculation_rate'), $masterProperty->propertyTypeName, $masterProperty->old_colony_name, date('Y-m-d'));
                    if (isset($landRateRow['error'])) {
                        return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.dataNotAvailable')]);
                    }
                    $landRate = !empty($landRateRow) ? $landRateRow->land_rate : null;
                    $area = $childProperty ? $childProperty->area_in_sqm : $masterProperty->propertyLeaseDetail->plot_area_in_sqm;
                    $landValue = ($landRate && $area > 0) ? round($landRate * $area, 2) : 0;
                    $propertyDetails = [
                        'old_property_id' => !is_null($childProperty) ? $childProperty->old_property_id : $masterProperty->old_propert_id,
                        'land_rate' => $landRate,
                        'area' => $area,
                        'land_value' => $landValue,
                        'address' => !is_null($childProperty) ? $childProperty->presently_known_as : $masterProperty->propertyLeaseDetail->presently_known_as,
                        'property_type' => $masterProperty->propertyTypeName,
                        'property_subtype' => $masterProperty->propertySubtypeName,
                    ];
                    return ['status' => 'success', 'landUseChangeData' => $matrixFilteredData, 'propertyDetails' => $propertyDetails];
                } else {
                    return response()->json(['status' => 'error', 'details' => 'Property not Found']);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'details' => 'Invalid property id given']);
        }
    }
}
