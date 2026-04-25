<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequisition extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function requisitionItems(){
        return $this->hasMany(PurchaseRequisitionItem::class, 'requisition_id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse(){
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
