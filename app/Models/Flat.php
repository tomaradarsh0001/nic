<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;
    protected $guarded = [];

     //Make flat & user properties relationship - Lalit (08/Nov/2024)
    public function userProperties()
    {
        return $this->hasMany(UserProperty::class, 'flat_id', 'id');
    }
}
