<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OldColony extends Model
{
    use HasFactory;
    protected $table = 'old_colonies';

    public static function colonyIdByColonyCode($code){

        return Self::select('id')->where('code', $code)->get();
    }

    public function propertyMasters()
    {
        return $this->hasMany(PropertyMaster::class, 'old_colony_name');
    }

    public function propertyMastersNew()
    {
        return $this->hasMany(PropertyMaster::class, 'new_colony_name');
    }
}
