<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Added by Lalit on 02/08/2024 Define the relationship to OldColony
    public function oldColony()
    {
        return $this->belongsTo(OldColony::class, 'locality');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'status', 'id');
    }
}
