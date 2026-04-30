<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['user_id',
        'total',
        'order_status',
        'shipping_full_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country'];

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
