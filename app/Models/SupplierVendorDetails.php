<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SupplierVendorDetails extends Model
{
    use HasFactory;
    protected $table = 'supplier_vendor_details';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'contact_no',
        'email',
        'office_address',
        'status',
        'is_tender',
        'from_tender',
        'to_tender',
        'created_by',
        'updated_by',
    ];

    public function SupplierVendorDetails(): BelongsTo
    {
        return $this->belongsTo(SupplierVendorDetails::class);
    }


}
