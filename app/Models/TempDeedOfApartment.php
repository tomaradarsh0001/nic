<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDeedOfApartment extends Model
{
    use HasFactory;
    protected $table = 'temp_deed_of_apartments';
    protected $guarded = [];

    public function getServiceTypeAttribute()
    {
        $serviceCode = 'DOA';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
