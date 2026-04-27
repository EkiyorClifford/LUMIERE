<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
