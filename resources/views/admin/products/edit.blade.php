{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\products\edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Edit Product')
@section('page-title', 'Edit Product')
@section('content')
<div class="page active" id="page-add-product">
    <div class="page-header">
        <div>
            <div class="page-eyebrow">CATALOGUE</div>
            <h1 class="page-title">Edit Product</h1>
        </div>
    </div>

    {{-- This primary form handles both details and Spatie image updates perfectly --}}
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="form-layout">
        @csrf 
        @method('PUT')
        
        <div class="card">
            <div class="card-head"><span class="card-title">Product Details</span></div>
            <div style="padding:24px" class="form-grid">
                <div class="field"><label class="field-label">NAME <span>*</span></label><input id="prod-name" oninput="autoSlug()" class="lux-input" name="name" value="{{ old('name', $product->name) }}" required></div>
                <div class="field"><label class="field-label">SLUG</label><input id="prod-slug" class="lux-input" name="slug" value="{{ old('slug', $product->slug) }}"></div>
                <div class="field"><label class="field-label">CATEGORY <span>*</span></label><select class="lux-select" name="category" required><option value="">Select a category</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(old('category', $product->category) == $category->slug)>{{ $category->name }}</option>@endforeach</select></div>
                <div class="field"><label class="field-label">COLLECTION</label><select class="lux-select" name="collection_id"><option value="">Unassigned</option>@foreach($collections as $collection)<option value="{{ $collection->id }}" @selected(old('collection_id', $product->collection_id) == $collection->id)>{{ $collection->name }}</option>@endforeach</select></div>
                <div class="field"><label class="field-label">PRICE <span>*</span></label><input class="lux-input" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required></div>
                <div class="field"><label class="field-label">SORT ORDER</label><input class="lux-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}"></div>
                <div class="field form-full"><label class="field-label">DESCRIPTION</label><textarea class="lux-textarea" name="description">{{ old('description', $product->description) }}</textarea></div>
                
                <div class="field form-full"><label class="field-label">CURRENT IMAGES</label>
                    <div class="grid grid-cols-4 gap-3 mb-4">
                        @foreach($product->galleryImageItems('thumb') as $image)
                            <div class="relative">
                                <img src="{{ $image['thumb_url'] }}" class="w-full h-32 object-cover rounded-sm">
                                <label class="absolute top-1 right-1 bg-white rounded-full p-1 cursor-pointer">
                                    <input type="checkbox" name="{{ $image['source'] === 'media' ? 'delete_media[]' : 'delete_images[]' }}" value="{{ $image['id'] }}" class="hidden">
                                    <i class="fa-solid fa-xmark text-xs text-charcoal"></i>
                                </label>
                                <label class="absolute top-1 left-1 bg-white rounded-sm px-2 py-1 text-[10px]">
                                    <input type="radio" name="{{ $image['source'] === 'media' ? 'primary_media_id' : 'primary_image_id' }}" value="{{ $image['id'] }}" @checked($image['is_primary'])>
                                    Primary
                                </label>
                                <div class="mt-2">
                                    <input class="lux-input" type="file" name="{{ $image['source'] === 'media' ? 'replace_media' : 'replace_images' }}[{{ $image['id'] }}]" accept="image/*">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-4"><label class="field-label">PRIMARY IMAGE (replace)</label><input class="lux-input" type="file" name="image" accept="image/*"></div>
                </div>
                <div class="field form-full"><label class="field-label">ADDITIONAL IMAGES</label><input class="lux-input" type="file" name="additional_images[]" accept="image/*" multiple></div>
            </div>
        </div>
        
        <div class="form-sidebar-card">
            <div class="form-sidebar-section">
                <div class="form-sidebar-title">PUBLISHING</div>
                <label class="toggle-wrap">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                    <span class="toggle-label">Active on storefront</span>
                </label>
            </div>
            <div class="form-sidebar-section">
                <button class="btn btn-gold" type="submit"><i class="fa-solid fa-check"></i> SAVE CHANGES</button>
            </div>
        </div>
    </form>
</div>
@endsection