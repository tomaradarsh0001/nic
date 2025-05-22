<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMembershipIhc extends Model
{
    use HasFactory;

    protected $table = 'ihcs_applications';

    protected $guarded = [];

    // Relationship with club_memberships
    public function membership()
    {
        return $this->belongsTo(ClubMembership::class, 'membership_app_id');
    }
}
