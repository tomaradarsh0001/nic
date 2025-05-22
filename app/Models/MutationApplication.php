<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutationApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function documentFinal(): HasMany
    {
        return $this->hasMany(Document::class, 'model_id')->where('model_name', 'MutationApplication');
    }

    public function propertyMaster() // to get address, to be used in getAttribute function -  Added By Nitin - 02-dec
    {
        return $this->belongsTo(PropertyMaster::class, 'property_master_id');
    }

    public function getSectionCodeAttribute()
    {
        $masterProperty = $this->propertyMaster;
        if ($masterProperty) {
            $sectionMapping = PropertySectionMapping::where('colony_id', $masterProperty->new_colony_name)->where('property_type', $masterProperty->property_type)->where('property_subtype', $masterProperty->property_sub_type)->first();
            if (!empty($sectionMapping)) {
                return $sectionMapping->section->section_code;
            }
        }
        return null;
    }

    public function getServiceTypeAttribute()
    {
        $serviceCode = 'SUB_MUT';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
