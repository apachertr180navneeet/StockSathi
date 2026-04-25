<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    } 

    public function warehouse(){
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function quotationItems(){
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }
}
