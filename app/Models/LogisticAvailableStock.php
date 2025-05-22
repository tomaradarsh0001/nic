<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticAvailableStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'logistic_items_id',
        'available_units',
        'used_units',
        'created_by',
        'updated_by',
    ];

    public function logisticItem()
    {
        return $this->belongsTo(LogisticItem::class, 'logistic_items_id');
    }


    public function logiticAvailableStock()
    {
        return $this->hasMany(LogisticAvailableStock::class);
    }





}
