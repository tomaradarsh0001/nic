<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LogisticItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'logistic_items';

    protected $fillable = [
        'label',
        'name',
        'category_id',
        'status',
        'created_by',
        'updated_by',

    ];
    // public function logisticItem(): BelongsTo
    // {
    //     return $this->belongsTo(LogisticItem::class);
    // }
    
    public function logisticCategory(): BelongsTo
    {
        return $this->belongsTo(LogisticCategory::class, 'category_id');
    }
    

    // public function logisticCategory(): HasOne
    // {
    //     return $this->hasOne(LogisticCategory::class, 'id', 'category_id');
    // }
    public function histories()
    {
        return $this->hasMany(LogisticsStockHistory::class);
    }

    public function availableStock(): HasOne
    {
        return $this->hasOne(LogisticAvailableStock::class, 'logistic_items_id');
    }

    public function latestRequest(): HasOne
    {
        return $this->hasOne(LogisticRequestItem::class, 'logistic_items_id')->latestOfMany();
    }

    public function requestItems()
    {
        return $this->hasMany(LogisticRequestItem::class, 'logistic_items_id');
    }

}
