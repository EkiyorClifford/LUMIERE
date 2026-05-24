{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\products\create.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Add Product')
@section('page-title', 'Add Product')
@section('content')
<div class="page active" id="page-add-product"><div class="page-header"><div><div class="page-eyebrow">CATALOGUE</div><h1 class="page-title">Add Product</h1></div></div>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="form-layout">@csrf
  <div class="card"><div class="card-head"><span class="card-title">Product Details</span></div><div style="padding:24px" class="form-grid">
    <div class="field"><label class="field-label">NAME <span>*</span></label><input id="prod-name" oninput="autoSlug()" class="lux-input" name="name" value="{{ old('name') }}" required></div>
    <div class="field"><label class="field-label">SLUG</label><input id="prod-slug" class="lux-input" name="slug" value="{{ old('slug') }}"></div>
    <div class="field"><label class="field-label">CATEGORY <span>*</span></label><select class="lux-select" name="category" required><option value="">Select a category</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(old('category') == $category->slug)>{{ $category->name }}</option>@endforeach</select></div>
    <div class="field"><label class="field-label">COLLECTION</label><select class="lux-select" name="collection_id"><option value="">Unassigned</option>@foreach($collections as $collection)<option value="{{ $collection->id }}">{{ $collection->name }}</option>@endforeach</select></div>
    <div class="field"><label class="field-label">PRICE <span>*</span></label><input class="lux-input" type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required></div>
    <div class="field"><label class="field-label">SORT ORDER</label><input class="lux-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}"></div>
    <div class="field form-full"><label class="field-label">DESCRIPTION</label><textarea class="lux-textarea" name="description">{{ old('description') }}</textarea></div>
    <div class="field form-full"><label class="field-label">PRIMARY IMAGE</label><input class="lux-input" type="file" name="image" accept="image/*"></div>
    <div class="field form-full"><label class="field-label">ADDITIONAL IMAGES</label><input class="lux-input" type="file" name="additional_images[]" accept="image/*" multiple></div>
  </div></div>
  <div class="form-sidebar-card"><div class="form-sidebar-section"><div class="form-sidebar-title">PUBLISHING</div><label class="toggle-wrap"><input type="checkbox" name="is_active" value="1" checked><span class="toggle-label">Active on storefront</span></label></div><div class="form-sidebar-section"><button class="btn btn-gold" type="submit"><i class="fa-solid fa-check"></i> SAVE PRODUCT</button></div></div>
</form></div>
@endsection
