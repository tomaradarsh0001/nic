<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyMaster extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function oldColony()
    {
        return $this->belongsTo(OldColony::class, 'old_colony_name');
    }

    public function newColony()
    {
        return $this->belongsTo(OldColony::class, 'new_colony_name');
    }

    public function propertyLeaseDetail(): HasOne
    {
        return $this->hasOne(PropertyLeaseDetail::class);
    }

    public function propertyTransferredLesseeDetails(): HasMany
    {
        return $this->hasMany(PropertyTransferredLesseeDetail::class, 'property_master_id');
    }


    public function propertyInspectionDemandDetail(): HasOne
    {
        return $this->hasOne(PropertyInspectionDemandDetail::class, 'property_master_id');
    }

    public function propertyMiscDetail(): HasOne
    {
        return $this->hasOne(PropertyMiscDetail::class, 'property_master_id');
    }

    public function propertyContactDetail(): HasOne
    {
        return $this->hasOne(PropertyContactDetail::class, 'property_master_id');
    }

    public function splitedPropertyDetail(): HasMany
    {
        return $this->hasMany(SplitedPropertyDetail::class, 'property_master_id');
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function currentLesseeName(): hasOne
    {
        return $this->hasOne(CurrentLesseeDetail::class, 'property_master_id')->whereNull('splited_property_detail_id');
    }

    public function getPropertyTypeNameAttribute()
    {
        return Item::itemNameById($this->property_type);
    }
    public function getPropertySubtypeNameAttribute()
    {
        return Item::itemNameById($this->property_sub_type);
    }
    public function getStatusNameAttribute()
    {
        return Item::itemNameById($this->status);
    }
    public function getLandTypeNameAttribute()
    {
        return Item::itemNameById($this->land_type);
    }
    public function splitedProperties()
    {
        return $this->hasMany(SplitedPropertyDetail::class, 'property_master_id');
    }
}
