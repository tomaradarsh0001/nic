<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class LogisticsStockHistory extends Model
{
    use HasFactory;

    protected $table = 'logistic_stock_histories';


    protected $guarded=[];

    protected $dates = ['created_at', 'updated_at', 'last_added_date', 'issued_at', 'last_reduced_date'];

    public function Purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function logisticRequest()
    {
        return $this->belongsTo(LogisticRequestItem::class, 'request_id');
    }


    public function issuedToUser()
    {
        return $this->belongsTo(User::class, 'issued_to_user_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    // public function logisticStockHistory()
    // {
    //     return $this->belongsTo(LogisticsStockHistory::class);
    // }

    public function logisticItem()
    {
        return $this->belongsTo(LogisticItem::class, 'logistic_items_id');
    }

    public function logisticCategory()
    {
        return $this->belongsTo(LogisticCategory::class, 'category_id');
    }

}
