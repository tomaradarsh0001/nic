<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationMovement extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    //Added by Lalit on 06/08/2024 Define the relationship to Items
    public function serviceType()
    {
        return $this->belongsTo(Item::class, 'service_type');
    }

    //Added by Lalit on 06/08/2024 Define the relationship to Users
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
