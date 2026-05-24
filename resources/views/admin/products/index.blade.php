{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\products\index.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Products')
@section('page-title', 'Products')

@section('content')
<div class="page active" id="page-products">
  <div class="page-header">
    <div><div class="page-eyebrow">CATALOGUE</div><h1 class="page-title">Products</h1></div>
    <a class="btn btn-gold" href="{{ route('admin.products.create') }}"><i class="fa-solid fa-plus"></i> <span>NEW PRODUCT</span></a>
  </div>

  <div class="list-filters">
    <input class="search-input" placeholder="Search products..." disabled>
    <span class="filter-pill active">ALL</span><span class="filter-pill">ACTIVE</span><span class="filter-pill">ARCHIVED</span>
  </div>

  <div class="card">
    <table>
      <thead><tr><th>IMAGE</th><th>NAME</th><th>CATEGORY</th><th>COLLECTION</th><th>PRICE</th><th>STATUS</th><th>ACTIONS</th></tr></thead>
      <tbody>
        @forelse($products as $product)
          <tr>
            <td><img class="prod-thumb" src="{{ $product->primaryImage?->image_url ?? 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=200&auto=format&fit=crop' }}" alt="{{ $product->name }}"></td>
            <td style="color:var(--text)">{{ $product->name }}</td>
            <td>{{ ucfirst($product->category) }}</td>
            <td>{{ $product->collection?->name ?? '—' }}</td>
            <td style="color:var(--gold)">${{ number_format($product->price, 2) }}</td>
            <td><span id="product-status-{{ $product->id }}" class="badge {{ $product->is_active ? 'badge-green' : 'badge-dim' }}">{{ $product->is_active ? 'Active' : 'Disabled' }}</span></td>
            <td>
              <div class="action-group">
                <button
                  class="action-btn"
                  title="Quick view"
                  data-name="{{ e($product->name) }}"
                  data-category="{{ e(ucfirst($product->category)) }}"
                  data-collection="{{ e($product->collection?->name ?? '—') }}"
                  data-price="{{ number_format($product->price, 2) }}"
                  data-status="{{ $product->is_active ? 'Active' : 'Disabled' }}"
                  data-description="{{ e($product->description ?: 'No description') }}"
                  onclick="openProductQuickView(this)">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <a class="action-btn" href="{{ route('admin.products.edit', $product) }}" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                <button class="action-btn danger" title="Toggle active" onclick="toggleProductActive({{ $product->id }})"><i class="fa-solid fa-power-off"></i></button>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-gem"></i><p>No products yet.<br>Create your first piece for the Lumière catalogue.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $products->links() }}
</div>

<div id="product-quick-view" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1000;padding:40px;">
  <div class="card" style="max-width:700px;margin:0 auto;background:var(--surface2)">
    <div class="card-head"><span class="card-title">Product Quick View</span><button class="action-btn" onclick="closeProductQuickView()"><i class="fa-solid fa-xmark"></i></button></div>
    <div style="padding:20px;font-size:.8rem;line-height:1.8">
      <p><strong>Name:</strong> <span id="qv-prod-name"></span></p>
      <p><strong>Category:</strong> <span id="qv-prod-category"></span></p>
      <p><strong>Collection:</strong> <span id="qv-prod-collection"></span></p>
      <p><strong>Price:</strong> $<span id="qv-prod-price"></span></p>
      <p><strong>Status:</strong> <span id="qv-prod-status"></span></p>
      <p><strong>Description:</strong><br><span id="qv-prod-description"></span></p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openProductQuickView(button){
  document.getElementById('qv-prod-name').textContent = button.dataset.name || '';
  document.getElementById('qv-prod-category').textContent = button.dataset.category || '';
  document.getElementById('qv-prod-collection').textContent = button.dataset.collection || '';
  document.getElementById('qv-prod-price').textContent = button.dataset.price || '';
  document.getElementById('qv-prod-status').textContent = button.dataset.status || '';
  document.getElementById('qv-prod-description').textContent = button.dataset.description || '';
  document.getElementById('product-quick-view').style.display = 'block';
}

function closeProductQuickView(){
  document.getElementById('product-quick-view').style.display = 'none';
}

async function toggleProductActive(id){
  const res = await fetch(`/admin/products/${id}/toggle-active`, {
    method: 'PATCH',
    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
  });

  if (!res.ok) return;

  const data = await res.json();
  const badge = document.getElementById(`product-status-${id}`);
  if (!badge) return;

  badge.textContent = data.label;
  badge.className = `badge ${data.is_active ? 'badge-green' : 'badge-dim'}`;
}
</script>
@endpush
