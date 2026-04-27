<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Shipment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'tracking_number',
        'shipping_method',
        'shipping_address',
        'shipped_at',
        'delivered_at',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
