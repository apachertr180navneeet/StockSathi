<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustmentItem extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function adjustment()
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustment_id', 'id');
    }
}
