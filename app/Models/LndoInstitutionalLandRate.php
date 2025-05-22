<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OldColony;

class LndoInstitutionalLandRate extends Model
{
    use HasFactory;

    
    // Manually define the 'updated_at'  so that it dont expect value for updated at column
    const UPDATED_AT  = null;
    protected $guarded = [];

    public function oldColony()
    {
        return $this->belongsTo(OldColony::class, 'old_colony_id');
    }
}
