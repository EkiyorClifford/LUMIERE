<?php

namespace App\Models;

// Just need the base Model class for this cart items model
use Database\Factories\CartItemsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    /** @use HasFactory<CartItemsFactory> */
    use HasFactory;

    /**
     * These fields can be mass-assigned
     * Cart items link products (and optionally variants) to a cart with quantity
     */
    protected $fillable = [
        'cart_id',      // Which cart this item belongs to
        'product_id',   // Which product is in the cart
        'variant_id',   // Optional: which variant (size, metal, etc.)
        'quantity',     // How many of this item
    ];

    /**
     * Get the cart this item belongs to.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product for this cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant for this cart item (if any).
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
