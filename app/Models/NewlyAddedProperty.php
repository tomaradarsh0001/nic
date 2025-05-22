<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewlyAddedProperty extends Model
{
    use HasFactory;
    protected $table ='newly_added_properties';
    protected $guarded = [];

    //Added by Lalit on 02/08/2024 Define the relationship to OldColony
    public function oldColony()
    {
        return $this->belongsTo(OldColony::class, 'locality');
    }

    // Define the relationship with the ApplicantUserDetails model
    public function applicantDetails()
    {
        return $this->hasOne(ApplicantUserDetail::class, 'user_id', 'user_id');
    }

    // Define the relationship with the Users model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'status', 'id');
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class, 'flat_id', 'id');
    }
}