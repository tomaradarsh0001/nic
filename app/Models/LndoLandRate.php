<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OldColony;

class LndoLandRate extends Model
{
    use HasFactory;
    protected $table = 'lndo_land_rate_colony_wise';
    protected $fillable = [
        'old_colony_id',
        'date_from',
        'date_to',
        'residential_land_rate',
        'commercial_land_rate',
        'institutional_land_rate',
        'industrial_land_rate'
    ];

    public function oldColony()
    {
        return $this->belongsTo(OldColony::class, 'old_colony_id');
    }
}
