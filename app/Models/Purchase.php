<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'purchases';


    protected $fillable = [
        'purchase_id',
        'logistic_items_id',
        'category_id',
        'purchased_unit',
        'reduced_unit',
        'purchased_date',
        'per_unit_cost',
        'total_cost',
        'vendor_supplier_id',
        'created_by',
        'updated_by',
    ];



    public function Purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
    public function stockHistories()
    {
        return $this->hasMany(LogisticsStockHistory::class, 'request_id', 'id');
    }

    public function logisticItem(): HasOne
    {
        return $this->hasOne(LogisticItem::class, 'id', 'logistic_items_id');
    }

    public function logisticCategory(): HasOne
    {
        return $this->hasOne(LogisticCategory::class, 'id', 'category_id');
    }
    public function SupplierVendorDetails(): HasOne
    {
        return $this->hasOne(SupplierVendorDetails::class, 'id', 'vendor_supplier_id');
    }
    public function histories()
    {
        return $this->hasMany(LogisticsStockHistory::class);
    }


}
