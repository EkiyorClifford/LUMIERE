<?php

namespace App\Models;

// I need these for defining relationships
// Model for base functionality
// BelongsTo for user relationship, HasMany for items
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wishlist extends Model
{
    /**
     * These fields can be mass-assigned
     * Wishlist is simple - it just needs to know which user owns it
     */
    protected $fillable = [
        'user_id',  // Foreign key to users table
    ];

    /**
     * Get the user who owns this wishlist
     * Each user gets one wishlist (created on demand when they first add something)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this wishlist
     * WishlistItem model stores the actual product references
     */
    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }
}
