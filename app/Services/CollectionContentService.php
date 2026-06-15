<?php

namespace App\Services;

use App\Models\CollectionContent;
use Illuminate\Database\Eloquent\Collection;

class CollectionContentService
{
    public function getBySlug(string $slug): ?CollectionContent
    {
        return CollectionContent::getBySlug($slug);
    }

    public function getAllActive(): Collection
    {
        return CollectionContent::active()->orderBy('slug')->get();
    }

    /**
     * @param  array{slug: string, title?: string, description?: string, image_url?: string|null, meta_description?: string|null, is_active?: bool}  $data
     */
    public function createOrUpdate(array $data): CollectionContent
    {
        return CollectionContent::updateOrCreate([
            'slug' => $data['slug'],
        ], $data);
    }

    public function delete(string $slug): bool
    {
        return CollectionContent::where('slug', $slug)->delete() > 0;
    }

    public function toggleActive(string $slug): CollectionContent
    {
        $content = CollectionContent::where('slug', $slug)->firstOrFail();

        return tap($content)->update([
            'is_active' => ! $content->is_active,
        ]);
    }
}
