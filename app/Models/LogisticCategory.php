<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogisticCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'logistic_categories';


    // public function logisticCategory(): BelongsTo
    // {
    //     return $this->belongsTo(LogisticCategory::class);
    // }
     public function histories()
    {
        return $this->hasMany(LogisticsStockHistory::class);
    }
    public function logisticItem(): HasMany
    {
        return $this->hasMany(LogisticItem::class, 'id', 'category_id');
    }

}
