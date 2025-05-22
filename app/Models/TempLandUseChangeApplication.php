<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLandUseChangeApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getServiceTypeAttribute()
    {
        $serviceCode = 'LUC';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
