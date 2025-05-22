<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demand extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['status_code', 'property_known_as', 'current_lessee'];
    public function demandDetails(): HasMany
    {
        return $this->hasMany(DemandDetail::class);
    }

    public function getStatusCodeAttribute()
    {
        return getServiceCodeById($this->status);
    }

    public function getPropertyKnownAsAttribute()
    {
        if (is_null($this->splited_property_detail_id)) {
            $propertyMaster = PropertyMaster::find($this->property_master_id);
            if ($propertyMaster) {
                return $propertyMaster->propertyLeaseDetail->presently_known_as ?? null;
            } else {
                return null;
            }
        } else {
            $spd = SplitedPropertyDetail::find($this->splited_property_detail_id);
            if ($spd) {
                return $spd->presently_known_as;
            } else {
                return null;
            }
        }
    }
    public function getCurrentLesseeAttribute()
    {
        if (is_null($this->splited_property_detail_id)) {
            $cld = CurrentLesseeDetail::where('property_master_id', $this->property_master_id)->whereNull('splited_property_detail_id')->first();
        } else {
            $cld = CurrentLesseeDetail::where('property_master_id', $this->property_master_id)->where('splited_property_detail_id', $this->splited_property_detail_id)->first();
        }
        return isset($cld) ? $cld->lessees_name : null;
    }
    public function getPropertyMasterAttribute()
    {
        return PropertyMaster::find($this->property_master_id);
    }
    public function getSplitedPropertyDetailAttribute()
    {
        return is_null($this->splited_property_detail_id) ? null : SplitedPropertyDetail::find($this->splited_property_detail_id);
    }

    public function includedOldDemands()
    {
        return $this->hasMany(OldDemand::class, 'new_demand_id');
    }
}