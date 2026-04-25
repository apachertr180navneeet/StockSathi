<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    } 

    public function warehouse(){
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function saleItems(){
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    public function delivery(){
        return $this->hasOne(Delivery::class, 'sale_id');
    }
}
