<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;

class Address extends Model
{
    //
    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'country',
        'is_default',
    ];
    //fillable are the fields that can be mass assigned by the user.
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //one address belongs to one user
    //is there a relationship btwn order and address?
    //yes, order has a shipping address field which is a snapshot of the address at the time of order
    //so order and address are not directly related.
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
