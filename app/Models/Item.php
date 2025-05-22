<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function itemNameById($id){

        $data =  Self::select('item_name')->where('id', $id)->first();
        if($data){
            return $data['item_name'];
        } else {
            return null;
        }
    }

    
    //Function to get the item id using item_code
    public static function getItemIdUsingItemCode($item_code, $group_id){
        $item_detail = Item::where('item_code', $item_code)->where('group_id', $group_id)->where('is_active', 1)->first();
        return !empty($item_detail) ? $item_detail->id : "";
    }

    public static function getItemIdByCode($item_code){
        $item_detail = Item::where('item_code', $item_code)->where('is_active', 1)->first();
        return !empty($item_detail) ? $item_detail->id : "";
    }

    public static function getItemNameByItemCode($item_code){
        $item_detail = Item::where('item_code', $item_code)->first();
        return !empty($item_detail) ? $item_detail->item_name : "";
    }
}
