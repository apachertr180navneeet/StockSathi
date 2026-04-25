<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function fromWarehouse(){
        return $this->belongsTo(WareHouse::class, 'from_warehouse_id');
    } 

    public function toWarehouse(){
        return $this->belongsTo(WareHouse::class, 'to_warehouse_id');
    }

    public function transferItems(){
        return $this->hasMany(TransferItem::class, 'transfer_id');
    }

}
