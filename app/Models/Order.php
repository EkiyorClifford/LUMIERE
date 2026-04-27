<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Shipment;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
}
