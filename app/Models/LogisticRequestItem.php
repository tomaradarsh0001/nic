<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogisticRequestItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];



    public function logisticItem(): BelongsTo
    {
        return $this->belongsTo(LogisticItem::class, 'logistic_items_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
    public function category()
    {
        return $this->belongsTo(LogisticCategory::class, 'category_id');
    }

    public function stockHistories()
    {
        return $this->hasMany(LogisticsStockHistory::class, 'request_id', 'id');
    }

}
