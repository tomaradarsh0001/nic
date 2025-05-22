<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatRate extends Model
{
    use HasFactory;

    protected $table = 'flat_rates';

    protected $fillable = [
        'property_type',
        'date_from',
        'date_to',
        'rate',
    ];
}
