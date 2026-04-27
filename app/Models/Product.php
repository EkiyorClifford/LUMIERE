<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\OrderItem;

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
    
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
