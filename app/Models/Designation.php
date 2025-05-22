<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sections()
    {
        return $this->hasManyThrough(
            Section::class,
            User::class,
            'designation_id', // Foreign key on User table
            'id', // Foreign key on Section table
            'id', // Local key on Designation table
            'section_id' // Local key on User table
        );
    }
}
