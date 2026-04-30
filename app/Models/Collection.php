<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'is_active',
        'sort_order',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
