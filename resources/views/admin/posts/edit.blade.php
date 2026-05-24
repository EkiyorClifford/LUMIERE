{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\posts\edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Edit Story')
@section('page-title', 'Edit Story')
@section('content')
<div class="page active" id="page-new-story"><div class="page-header"><div><div class="page-eyebrow">JOURNAL</div><h1 class="page-title">Edit Story</h1></div></div>
<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="form-layout">@csrf @method('PUT')
<div class="card"><div class="card-head"><span class="card-title">Story Details</span></div><div style="padding:24px" class="form-grid">
<div class="field"><label class="field-label">TITLE <span>*</span></label><input id="story-title" oninput="autoStorySlug()" class="lux-input" name="title" value="{{ old('title', $post->title) }}" required></div>
<div class="field"><label class="field-label">SLUG</label><input id="story-slug" class="lux-input" name="slug" value="{{ old('slug', $post->slug) }}"></div>
<div class="field"><label class="field-label">VOLUME</label><input class="lux-input" name="volume_label" value="{{ old('volume_label', $post->volume_label) }}"></div>
<div class="field"><label class="field-label">CATEGORY</label><select class="lux-select" name="post_category_id"><option value="">Uncategorized</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
<div class="field form-full"><label class="field-label">EXCERPT <span>*</span></label><textarea class="lux-textarea" name="excerpt" required>{{ old('excerpt', $post->excerpt) }}</textarea></div>
<div class="field form-full"><label class="field-label">BODY <span>*</span></label><textarea class="rich-content" name="content" required>{{ old('content', $post->content) }}</textarea></div>
<div class="field form-full"><label class="field-label">FEATURED IMAGE</label><input class="lux-input" type="file" name="featured_image" accept="image/*"></div>
</div></div><div class="form-sidebar-card"><div class="form-sidebar-section"><div class="form-sidebar-title">STATUS</div><label class="toggle-wrap"><input type="checkbox" name="publish" value="1" @checked(old('publish', (bool) $post->published_at))><span class="toggle-label">Published</span></label></div><div class="form-sidebar-section"><button class="btn btn-gold">SAVE STORY</button></div></div></form></div>
@endsection
