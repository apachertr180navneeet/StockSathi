<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id','id');
    }

    public function warehouse(){
        return $this->belongsTo(WareHouse::class, 'warehouse_id','id');
    }

    public function salesOrderItems(){
        return $this->hasMany(SalesOrderItem::class, 'sales_order_id', 'id');
    }
}
