<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempSubstitutionMutation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'temp_substitution_mutation';
    public function getServiceTypeAttribute()
    {
        $serviceCode = 'SUB_MUT';
        $serviceType = Item::where('item_code', $serviceCode)->first();
        return $serviceType;
    }
}
