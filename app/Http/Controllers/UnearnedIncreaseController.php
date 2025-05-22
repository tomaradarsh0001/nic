<?php

namespace App\Http\Controllers;

use App\Services\ColonyService;
use App\Services\LandRateService;
use App\Services\PropertyMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnearnedIncreaseController extends Controller
{
    public function index(ColonyService $colonyService)
    {
        $data = [];
        $user = Auth::user();
        if ($user->user_type == 'applicant') {
            $data['isApplicant'] = true;
            $data['properties'] = $user->userProperties;
        } else {
            $data['colonies'] = $colonyService->misDoneForColonies();
        }
        return view('calculation.unearned-increase', $data);
    }

    public function propertyDetails($propertyId)
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
                    $landRateService = new LandRateService();
                    $landRateRow = $landRateService->getLandRates(config('constants.conversion_calculation_rate'), $masterProperty->propertyTypeName, $masterProperty->old_colony_name, date('Y-m-d'));
                    if (isset($landRateRow['error'])) {
                        return response()->json(['status' => 'error', 'details' => config('messages.landUseChange.error.dataNotAvailable')]);
                    }
                    $landRate = !empty($landRateRow) ? $landRateRow->land_rate : null;
                    $area = $childProperty ? $childProperty->area_in_sqm : $masterProperty->propertyLeaseDetail->plot_area_in_sqm;
                    $landValue = ($landRate && $area > 0) ? round($landRate * $area, 2) : 0;
                    $unearnedIncrease = config('constants.unearned_increase_factor') * $landValue;
                    $propertyDetails = [
                        'old_property_id' => !is_null($childProperty) ? $childProperty->old_property_id : $masterProperty->old_propert_id,
                        'land_rate' => $landRate,
                        'area' => $area,
                        'land_value' => '₹ ' . customNumFormat($landValue),
                        'address' => !is_null($childProperty) ? $childProperty->presently_known_as : $masterProperty->propertyLeaseDetail->presently_known_as,
                        'unearned_increase' => '₹ ' . customNumFormat(round($unearnedIncrease, 2)),
                    ];
                    return ['status' => 'success', 'propertyDetails' => $propertyDetails];
                } else {
                    return response()->json(['status' => 'error', 'details' => 'Property not Found']);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'details' => 'Invalid property id given']);
        }
    }
}
