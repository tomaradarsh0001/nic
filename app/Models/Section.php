<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    //User have many sections
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function propertySectionMappings(): HasMany
    {
        return $this->hasMany(PropertySectionMapping::class);
    }

    public function publicgrievances()
    {
        return $this->hasMany(AdminPublicGrievance::class, 'section_ids', 'section_code');
    }
}
