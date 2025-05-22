<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyRevivisedGroundRent extends Model
{
    use HasFactory;
    protected $table = 'property_revivised_ground_rent';
    protected $guarded = [];
    protected $appends = ['address', 'draftPath', 'demandId', 'propertyId'];
    public function splitedPropertyDetail() // to get address, ro be used in getAttribute function
    {
        return $this->belongsTo(SplitedPropertyDetail::class, 'splited_property_detail_id');
    }

    public function propertyMaster() // to get address, to be used in getAttribute function
    {
        return $this->belongsTo(PropertyMaster::class, 'property_master_id');
    }

    public function getAddressAttribute() // to add address of property when fetched // added by Nitin 19072024
    {
        if (!is_null($this->splited_property_detail_id)) {
            $splitedProperty = $this->splitedPropertyDetail;
            if ($splitedProperty && !empty($splitedProperty->presently_known_as)) {
                return $splitedProperty->presently_known_as;
            }
        } else {
            $masterProperty = $this->propertyMaster;
            if ($masterProperty && $masterProperty->propertyLeaseDetail && !empty($masterProperty->propertyLeaseDetail->presently_known_as)) {
                return $masterProperty->propertyLeaseDetail->presently_known_as;
            }
        }

        return '';
    }
    public function getContactDetailsAttribute() // to add address of property when fetched // added by Nitin 29072024
    {
        if (!is_null($this->splited_property_detail_id)) {
            $splitedProperty = $this->splitedPropertyDetail;
            if ($splitedProperty && !is_null($splitedProperty->propertyContactDetail)) {
                return $splitedProperty->propertyContactDetail;
            }
        } else {
            $masterProperty = $this->propertyMaster;
            if ($masterProperty && !is_null($masterProperty->propertyContactDetail)) {
                return $masterProperty->propertyContactDetail;
            }
        }
        return null;
    }

    public function getAmountAttribute()
    {
        if ($this->calculated_on_rate == 'L') {
            return $this->lndo_rgr ?? 0;
        }
        if ($this->calculated_on_rate == 'C') {
            return $this->circle_rgr ?? 0;
        }
    }

    public function getDemandDetailsAttribute()
    {
        return DemandDetail::where('model', 'PropertyRevivisedGroundRent')->where('model_id', $this->id)->first();
        //return $this->belongsTo(DemandDetail::class, 'model_id')->where('model', 'PropertyRevivisedGroundRent');
    }

    public function getPropertyIdAttribute()
    {
        if (is_null($this->splited_property_detail_id)) {
            return $this->propertyMaster->old_propert_id;
        } else {
            return $this->splitedPropertyDetail->old_property_id;
        }
    }

    public function getDraftPathAttribute()
    {
        if (is_null($this->draft_file_path)) {
            return null;
        } else {
            return str_replace('public', 'storage', $this->draft_file_path);
        }
    }

    public function getDemandIdAttribute()
    {
        if (!empty($this->demandDetails)) {
            return $this->demandDetails->demand->unique_demand_id;
        }
        return null;
    }
}
