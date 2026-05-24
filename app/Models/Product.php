<?php

namespace App\Models;

// I need these for defining relationships and model behavior
// Model for base Eloquent functionality
// BelongsTo, HasMany, HasOne for relationship types
// SoftDeletes because I want to keep deleted products for recovery
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use SoftDeletes; // Soft delete products instead of permanently deleting them

    /**
     * These fields can be mass-assigned
     * I'm allowing all the basic product fields that I'll be setting from forms or seeders
     */
    protected $fillable = [
        'name',            // Product name (e.g., "Solitaire Diamond Ring")
        'collection_id',   // Foreign key to collections table
        'category',        // Product category (e.g., "rings", "necklaces")
        'description',     // Long description for product detail page
        'price',           // Base price (variants can modify this)
        'is_active',       // Whether product is visible on the site
        'slug',            // URL-friendly name for routes
        'sort_order',      // Manual ordering for display
    ];

    /**
     * Cast these attributes to native types
     * This ensures proper type handling when working with the model
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',   // Convert 0/1 to true/false
            'price' => 'decimal:2',     // Keep price as decimal with 2 places for accuracy
        ];
    }

    /**
     * Get the collection this product belongs to
     * A product can be in one collection (e.g., "Eternal Love Collection")
     */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Backward compatibility alias
     * I had this as plural originally but keeping it for any old code that might reference it
     *
     * @phpstan-ignore-next-line Backward compatible alias for the old plural method.
     */
    public function collections(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Get all images for this product
     * Ordered by sort_order so I control the display sequence in galleries
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get all order items that include this product
     * Useful for analytics and order history
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all variants for this product
     * Variants handle things like ring sizes, metal types, stone options
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get all attributes for this product
     * Attributes are specifications like metal purity, carat weight, dimensions
     * Ordered by sort_order for consistent display
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class)->orderBy('sort_order');
    }

    /**
     * Get the primary image for this product
     * This is the main thumbnail image used in listings and quick views
     * Falls back to first image if no primary is marked
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true)->orderBy('sort_order');
    }

    /**
     * Use slug instead of ID for route model binding
     * This gives me clean URLs like /products/solitaire-diamond-ring
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all reviews for this product
     * Customer reviews are displayed on the product detail page
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
