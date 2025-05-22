<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantUserDetail extends Model
{
    use HasFactory;
    protected $table = 'applicant_user_details';
    protected $guarded = [];

    // Define the relationship with the NewlyAddedProperty model
    public function newlyAddedProperty()
    {
        return $this->belongsTo(NewlyAddedProperty::class, 'user_id', 'user_id');
    }

    // Define the relationship with the Users model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
