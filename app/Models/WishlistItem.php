<?php

namespace App\Models;

// I need these for defining relationships
// Model for base functionality
// BelongsTo for linking to wishlist and product
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistItem extends Model
{
    /**
     * These fields can be mass-assigned
     * Wishlist items are simple - just link a product to a wishlist
     */
    protected $fillable = [
        'wishlist_id',  // Which wishlist this item belongs to
        'product_id',   // Which product is wishlisted
    ];

    /**
     * Get the wishlist this item belongs to
     */
    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    /**
     * Get the product for this wishlist item
     * This gives me access to product details for display
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
