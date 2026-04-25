<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    protected $guarded = [];

    public function salesOrder(){
        return $this->belongsTo(SalesOrder::class, 'sales_order_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
