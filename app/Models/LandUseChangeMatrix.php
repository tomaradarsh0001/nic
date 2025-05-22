<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LandUseChangeMatrix extends Model
{
    use HasFactory;
    protected $table = 'land_use_change_matrix';

    public function getAllowedOptions($propertyType, $propertySubtype)
    {
        return DB::table('land_use_change_matrix as lcm')
            ->where('property_type_from', $propertyType)
            ->where('property_sub_type_from', $propertySubtype)
            ->whereDate('date_from', '<=', date('Y-m-d'))
            ->where(function ($query) {
                return $query->whereNull('date_to')->orWhere('date_to', '>', date('Y-m-d'));
            })
            ->leftJoin('items as fromTypeName', 'lcm.property_type_from', '=', 'fromTypeName.id')
            ->leftJoin('items as fromSubtypeName', 'lcm.property_sub_type_from', '=', 'fromSubtypeName.id')
            ->leftJoin('items as toTypeName', 'lcm.property_type_to', '=', 'toTypeName.id')
            ->leftJoin('items as toSubtypeName', 'lcm.property_sub_type_to', '=', 'toSubtypeName.id')
            ->select(['lcm.*', 'fromTypeName.item_name as fromTypeName', 'fromSubtypeName.item_name as fromSubtypeName', 'toTypeName.item_name as toTypeName', 'toSubtypeName.item_name as toSubtypeName'])
            ->get();
    }
}
