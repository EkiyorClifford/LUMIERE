{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\collections\index.blade.php --}}
@extends('layouts.admin')

@section('title', 'LUMIÈRE · Collections')
@section('page-title', 'Collections')

@section('content')
<div class="page active" id="page-collections">
  <div class="page-header">
    <div>
      <div class="page-eyebrow">CATALOGUE</div>
      <h1 class="page-title">Collections</h1>
    </div>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>NAME</th>
          <th>SLUG</th>
          <th>PRODUCTS</th>
          <th>STATUS</th>
          <th>SORT ORDER</th>
        </tr>
      </thead>
      <tbody>
        @forelse($collections as $collection)
          <tr>
            <td style="color:var(--text)">{{ $collection->name }}</td>
            <td>{{ $collection->slug }}</td>
            <td>{{ $collection->products_count }}</td>
            <td>
              <span class="badge {{ $collection->is_active ? 'badge-green' : 'badge-dim' }}">
                {{ $collection->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>{{ $collection->sort_order }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <i class="fa-solid fa-layer-group"></i>
                <p>No collections yet.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $collections->links() }}
</div>
@endsection
