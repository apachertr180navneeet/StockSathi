<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionItem extends Model
{
    protected $guarded = [];

    public function requisition(){
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
