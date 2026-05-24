{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\posts\index.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Journal')
@section('page-title', 'Journal — All Stories')
@section('content')
<div class="page active" id="page-journal">
  <div class="page-header"><div><div class="page-eyebrow">JOURNAL</div><h1 class="page-title">All Stories</h1></div><a class="btn btn-gold" href="{{ route('admin.posts.create') }}"><i class="fa-solid fa-plus"></i> <span>NEW STORY</span></a></div>
  <div class="card">
    <table>
      <thead><tr><th>TITLE</th><th>VOLUME</th><th>CATEGORY</th><th>STATUS</th><th>CREATED</th><th>ACTIONS</th></tr></thead>
      <tbody>
        @forelse($posts as $post)
          <tr>
            <td style="color:var(--text)">{{ $post->title }}</td>
            <td><span class="chip">{{ $post->volume_label ?? '—' }}</span></td>
            <td><span class="badge badge-amber">{{ $post->category?->name ?? 'Uncategorized' }}</span></td>
            <td><span class="badge {{ $post->published_at ? 'badge-green' : 'badge-dim' }}">{{ $post->published_at ? 'Published' : 'Draft' }}</span></td>
            <td style="color:var(--text-dim)">{{ $post->created_at->format('M d, Y') }}</td>
            <td><div class="action-group"><button class="action-btn" title="Quick view" data-title="{{ e($post->title) }}" data-volume="{{ e($post->volume_label ?? '—') }}" data-category="{{ e($post->category?->name ?? 'Uncategorized') }}" data-status="{{ $post->published_at ? 'Published' : 'Draft' }}" data-created="{{ $post->created_at->format('M d, Y H:i') }}" data-excerpt="{{ e($post->excerpt) }}" onclick="openPostQuickView(this)"><i class="fa-solid fa-expand"></i></button><a class="action-btn" href="{{ route('admin.posts.edit', $post) }}"><i class="fa-solid fa-pen-to-square"></i></a><form method="POST" action="{{ route('admin.posts.destroy', $post) }}">@csrf @method('DELETE')<button class="action-btn danger"><i class="fa-solid fa-trash"></i></button></form></div></td>
          </tr>
        @empty
          <tr><td colspan="6"><div class="empty-state"><i class="fa-solid fa-book-open"></i><p>No journal stories yet.<br>Draft and published stories will appear here.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $posts->links() }}
</div>

<div id="post-quick-view" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1000;padding:40px;">
  <div class="card" style="max-width:700px;margin:0 auto;background:var(--surface2)">
    <div class="card-head"><span class="card-title">Story Quick View</span><button class="action-btn" onclick="closePostQuickView()"><i class="fa-solid fa-xmark"></i></button></div>
    <div style="padding:20px;font-size:.8rem;line-height:1.8">
      <p><strong>Title:</strong> <span id="qv-post-title"></span></p>
      <p><strong>Volume:</strong> <span id="qv-post-volume"></span></p>
      <p><strong>Category:</strong> <span id="qv-post-category"></span></p>
      <p><strong>Status:</strong> <span id="qv-post-status"></span></p>
      <p><strong>Created:</strong> <span id="qv-post-created"></span></p>
      <p><strong>Excerpt:</strong><br><span id="qv-post-excerpt"></span></p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openPostQuickView(button){
  document.getElementById('qv-post-title').textContent = button.dataset.title || '';
  document.getElementById('qv-post-volume').textContent = button.dataset.volume || '';
  document.getElementById('qv-post-category').textContent = button.dataset.category || '';
  document.getElementById('qv-post-status').textContent = button.dataset.status || '';
  document.getElementById('qv-post-created').textContent = button.dataset.created || '';
  document.getElementById('qv-post-excerpt').textContent = button.dataset.excerpt || '';
  document.getElementById('post-quick-view').style.display = 'block';
}
function closePostQuickView(){ document.getElementById('post-quick-view').style.display = 'none'; }
</script>
@endpush
