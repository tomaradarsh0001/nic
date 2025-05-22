<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMembership extends Model
{
    use HasFactory;
    protected $table = 'club_membership_applications';

    protected $guarded = [];

    // Relationship with items table
    public function statusItem()
    {
        return $this->belongsTo(Item::class, 'status');
    }

    // Relationship with club_membership_dgcs
    public function dgcDetails()
    {
        return $this->hasOne(ClubMembershipDgc::class, 'membership_app_id');
    }

    // Relationship with club_membership_ihcs
    public function ihcDetails()
    {
        return $this->hasOne(ClubMembershipIhc::class, 'membership_app_id');
    }
}
