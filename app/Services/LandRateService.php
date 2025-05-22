<?php

namespace App\Services;

use App\Models\Item;

class LandRateService
{
    public function getLandRates($from, $propertyType, $colony_id, $fromDate)
    {
        if (!in_array(strtolower($propertyType), ['residential', 'commercial'])) {
            return ['error' => 'data not available for ' . $propertyType . ' properites'];
        }
        $modelName = ucfirst($from) . ucfirst($propertyType) . 'LandRate';
        $model = '\\App\\Models\\' . $modelName;
        return $model::where('colony_id', $colony_id)->where(function ($query) use ($fromDate) {

            return $query->whereDate('date_from', '<=', $fromDate)->whereDate('date_to', '>=', $fromDate)->orWhere(
                function ($q1) use ($fromDate) {
                    return $q1->whereNull('date_from')->whereDate('date_to', '>=', $fromDate);
                }
            )->orWhere(function ($q2) use ($fromDate) {
                return $q2->whereNull('date_to')->whereDate('date_from', '<=', $fromDate);
            });
        })->first();
    }

    public function getApplicantTyps()
    {
        return Item::where('group_id', 4001)->where('is_active', 1)->orderBy('item_order')->get();
    }
}
