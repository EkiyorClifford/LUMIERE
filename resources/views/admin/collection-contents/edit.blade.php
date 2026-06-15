@extends('layouts.admin')

@section('title', 'Edit Collection Content')
@section('page-title', 'Collection Pages')

@section('content')
<div class="page-header">
    <div>
        <p class="page-eyebrow">CATALOGUE</p>
        <h1 class="page-title">Edit Collection Page</h1>
    </div>
    <a href="{{ route('admin.collection-contents.index') }}" class="btn btn-outline">
        <i class="fa-solid fa-arrow-left"></i>
        Back
    </a>
</div>

<form action="{{ route('admin.collection-contents.update', $content) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-head">
            <h2 class="card-title">{{ $content->slug }}</h2>
        </div>
        <div style="padding: 24px;">
            <div class="form-grid">
                <div class="field">
                    <label class="field-label" for="slug">Slug</label>
                    <input id="slug" type="text" value="{{ $content->slug }}" class="lux-input" disabled>
                </div>

                <div class="field">
                    <label class="field-label" for="title">Title <span>*</span></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $content->title) }}" class="lux-input" required>
                    @error('title')<p style="color: var(--red); font-size: 0.68rem; margin-top: 6px;">{{ $message }}</p>@enderror
                </div>

                <div class="field form-full">
                    <label class="field-label" for="description">Description <span>*</span></label>
                    <textarea id="description" name="description" class="lux-textarea" rows="6" required>{{ old('description', $content->description) }}</textarea>
                    @error('description')<p style="color: var(--red); font-size: 0.68rem; margin-top: 6px;">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="image_url">Image URL</label>
                    <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $content->image_url) }}" class="lux-input">
                    @error('image_url')<p style="color: var(--red); font-size: 0.68rem; margin-top: 6px;">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="lux-textarea" rows="3">{{ old('meta_description', $content->meta_description) }}</textarea>
                    @error('meta_description')<p style="color: var(--red); font-size: 0.68rem; margin-top: 6px;">{{ $message }}</p>@enderror
                </div>

                <div class="field form-full">
                    <label class="status-pill {{ old('is_active', $content->is_active) ? 'selected' : '' }}" style="display: inline-flex;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }}>
                        <span class="dot {{ old('is_active', $content->is_active) ? 'dot-green' : 'dot-red' }}"></span>
                        Active
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="action-group">
        <button type="submit" class="btn btn-gold">
            <i class="fa-solid fa-check"></i>
            Save
        </button>
        <a href="{{ route('admin.collection-contents.index') }}" class="btn btn-outline">Cancel</a>
    </div>
</form>
@endsection
