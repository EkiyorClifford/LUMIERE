<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    //
    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'quantity',
    ];

    public function Cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
