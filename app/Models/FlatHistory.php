<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlatHistory extends Model
{
    use HasFactory;
    use SoftDeletes; // Enable soft deletes
    protected $guarded = [];
    // Optionally, define the column used for soft deletes
    protected $dates = ['deleted_at'];
}
