<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function PaymentDetails(): HasMany
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
