<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempNoc extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'temp_nocs';
    public function getServiceTypeAttribute()
    {
        $serviceCode = 'NOC';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
