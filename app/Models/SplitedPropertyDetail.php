<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SplitedPropertyDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function propertyTransferredLesseeDetails(): HasMany
    {
        return $this->hasMany(PropertyTransferredLesseeDetail::class, 'splited_property_detail_id');
    }

    public function propertyInspectionDemandDetail(): HasOne
    {
        return $this->hasOne(PropertyInspectionDemandDetail::class, 'splited_property_detail_id');
    }

    public function propertyMiscDetail(): HasOne
    {
        return $this->hasOne(PropertyMiscDetail::class, 'splited_property_detail_id');
    }

    public function propertyContactDetail(): HasOne
    {
        return $this->hasOne(PropertyContactDetail::class, 'splited_property_detail_id');
    }
    public function currentLesseeName(): HasOne
    {
        return $this->hasOne(CurrentLesseeDetail::class, 'splited_property_detail_id');
    }
    public function master(): BelongsTo
    {
        return $this->belongsTo(PropertyMaster::class, 'property_master_id', 'id');
    }
    public function getStatusNameAttribute()
    {
        return Item::itemNameById($this->property_status);
    }
}
