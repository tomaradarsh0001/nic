<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AdminPublicGrievance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function colonyName()
    {
        return $this->belongsTo(OldColony::class, 'colony', 'id');
    }

    public function sectionName()
    {
        return $this->belongsTo(Section::class, 'section_ids', 'id');
    }

    public function statusItem()
    {
        return $this->belongsTo(Item::class, 'status', 'id');
    }

    public function remarks()
    {
        return $this->hasMany(GrievanceRemark::class, 'grievance_id');
    }
}
