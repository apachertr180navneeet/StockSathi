<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $guarded = [];

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id', 'id');
    }

    public function bins()
    {
        return $this->hasMany(Bin::class);
    }
}
