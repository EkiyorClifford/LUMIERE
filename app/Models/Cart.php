<?php

namespace App\Models;

// Just need the base Model class for this simple cart model
use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<CartFactory> */
    use HasFactory;

    /**
     * These fields can be mass-assigned
     * Cart is pretty simple - it just needs to know who it belongs to
     */
    protected $fillable = [
        'user_id',     // For logged-in users' carts
        'session_id',  // For guest carts (though I'm actually using session storage for guests)
    ];

    /**
     * Get the user who owns this cart
     * Only used for authenticated users' carts
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this cart
     * CartItems model stores the actual products, quantities, and variants
     */
    public function items()
    {
        return $this->hasMany(CartItems::class);
    }
}
