<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrievanceRemark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function grievance()
    {
        return $this->belongsTo(AdminPublicGrievance::class, 'grievance_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
