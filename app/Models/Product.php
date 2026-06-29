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
use Illuminate\Support\Collection as SupportCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    public const ProductImagesCollection = 'product-images';

    /** @use HasFactory<ProductFactory> */
    use HasFactory;
    use InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ProductImagesCollection)
            ->useDisk('public')
            ->acceptsMimeTypes([
                'image/avif',
                'image/jpeg',
                'image/png',
                'image/webp',
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(320)
            ->format('webp')
            ->quality(82)
            ->performOnCollections(self::ProductImagesCollection);

        $this->addMediaConversion('card')
            ->width(900)
            ->format('webp')
            ->quality(84)
            ->withResponsiveImages()
            ->performOnCollections(self::ProductImagesCollection);

        $this->addMediaConversion('gallery')
            ->width(1600)
            ->format('webp')
            ->quality(86)
            ->withResponsiveImages()
            ->performOnCollections(self::ProductImagesCollection);

        $this->addMediaConversion('hero')
            ->width(2400)
            ->format('webp')
            ->quality(86)
            ->withResponsiveImages()
            ->performOnCollections(self::ProductImagesCollection);

        $this->addMediaConversion('zoom')
            ->width(4096)
            ->format('webp')
            ->quality(88)
            ->performOnCollections(self::ProductImagesCollection);
    }

    public function primaryImageMedia(): ?Media
    {
        $media = $this->getMedia(self::ProductImagesCollection);

        return $media->first(
            fn (Media $media): bool => (bool) $media->getCustomProperty('primary', false)
        ) ?? $media->first();
    }

    public function productImageUrl(string $conversion = 'card'): ?string
    {
        $media = $this->primaryImageMedia();

        if ($media) {
            return $media->getAvailableUrl([$conversion, 'gallery', 'card', 'thumb']);
        }

        return $this->legacyPrimaryImageUrl();
    }

    /**
     * @return SupportCollection<int, array{id: int|string, url: string, thumb_url: string, is_primary: bool, sort_order: int|null, source: string}>
     */
    public function galleryImageItems(string $conversion = 'gallery'): SupportCollection
    {
        $mediaItems = $this->getMedia(self::ProductImagesCollection);

        if ($mediaItems->isNotEmpty()) {
            return $mediaItems->map(fn (Media $media): array => [
                'id' => $media->id,
                'url' => $media->getAvailableUrl([$conversion, 'gallery', 'card', 'thumb']),
                'thumb_url' => $media->getAvailableUrl(['thumb', 'card']),
                'is_primary' => (bool) $media->getCustomProperty('primary', false),
                'sort_order' => $media->order_column,
                'source' => 'media',
            ]);
        }

        return $this->legacyImages()->map(fn (ProductImage $image): array => [
            'id' => $image->id,
            'url' => $image->image_url,
            'thumb_url' => $image->image_url,
            'is_primary' => (bool) $image->is_primary,
            'sort_order' => $image->sort_order,
            'source' => 'legacy',
        ]);
    }

    private function legacyPrimaryImageUrl(): ?string
    {
        $primaryImage = $this->relationLoaded('primaryImage')
            ? $this->primaryImage
            : $this->primaryImage()->first();

        if ($primaryImage) {
            return $primaryImage->image_url;
        }

        return $this->legacyImages()->first()?->image_url;
    }

    /**
     * @return SupportCollection<int, ProductImage>
     */
    private function legacyImages(): SupportCollection
    {
        return $this->relationLoaded('images')
            ? $this->images
            : $this->images()->get();
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
