<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempConversionApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tempDocument(): HasMany
    {
        return $this->hasMany(TempDocument::class, 'model_id')->where('model_name', 'TempConversionApplication');
    }

    public function getServiceTypeAttribute()
    {
        $serviceCode = 'CONVERSION';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
