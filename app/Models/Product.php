<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock',
        'is_active',
        'slug',
    ];

    public function collections()
    {
        return $this->belongsTo(Collection::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
