<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CollectionContent extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'image_url',
        'meta_description',
        'is_active',
    ];

    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    public static function active(): Builder
    {
        return self::where('is_active', true);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
