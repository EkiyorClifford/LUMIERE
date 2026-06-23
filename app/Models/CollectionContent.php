<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CollectionContent extends Model
{
    /**
     * The fields that can be filled in one call.
     *
     * These records are used for the collections page content, so the model
     * only needs the editorial fields that the admin panel and seeders manage.
     */
    protected $fillable = [
        'slug',
        'title',
        'description',
        'image_url',
        'meta_description',
        'is_active',
    ];

    /**
     * Fetch one active collection content record by its slug.
     *
     * This is the main lookup used by the frontend when rendering a specific
     * collection page. Returning `null` lets the caller decide how to handle
     * missing or inactive content.
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Start a query for only active collection content records.
     *
     * Other parts of the app chain extra clauses onto this, such as ordering
     * or pagination, so we return the query builder instead of the result set.
     */
    public static function active(): Builder
    {
        return self::where('is_active', true);
    }

    /**
     * Cast database values into native PHP types.
     *
     * `is_active` is stored as a tiny integer in the database, but we want to
     * work with it as a real boolean in PHP code and Blade templates.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
