<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionMatrix extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table="action_matrixes";
}
