{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\orders\index.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Orders')
@section('page-title', 'Orders')
@section('content')
<div class="page active" id="page-orders">
  <div class="page-header"><div><div class="page-eyebrow">COMMERCE</div><h1 class="page-title">Orders</h1></div></div>
  <div class="card">
    <table>
      <thead><tr><th>ORDER</th><th>CUSTOMER</th><th>EMAIL</th><th>TOTAL</th><th>STATUS</th><th>DATE</th><th>ACTIONS</th></tr></thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
            <td style="color:var(--text)">{{ $order->order_number ?? '#'.$order->id }}</td>
            <td>{{ $order->user?->name ?? 'Guest' }}</td>
            <td>{{ $order->user?->email ?? '—' }}</td>
            <td style="color:var(--gold)">${{ number_format($order->total, 2) }}</td>
            <td><span class="badge badge-gold">{{ ucfirst($order->order_status) }}</span></td>
            <td style="color:var(--text-dim)">{{ $order->created_at->format('M d, Y') }}</td>
            <td><div class="action-group"><button class="action-btn" title="Quick view" data-order="{{ $order->order_number ?? '#'.$order->id }}" data-customer="{{ $order->user?->name ?? 'Guest' }}" data-email="{{ $order->user?->email ?? '—' }}" data-total="{{ number_format($order->total, 2) }}" data-status="{{ ucfirst($order->order_status) }}" data-date="{{ $order->created_at->format('M d, Y H:i') }}" onclick="openOrderQuickView(this)"><i class="fa-solid fa-expand"></i></button><a class="action-btn" href="{{ route('admin.orders.show', $order) }}"><i class="fa-solid fa-eye"></i></a></div></td>
          </tr>
        @empty
          <tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-bag-shopping"></i><p>No orders yet.<br>When customers complete checkout, orders will appear here with full shipping, payment, and status management.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $orders->links() }}
</div>

<div id="order-quick-view" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1000;padding:40px;">
  <div class="card" style="max-width:700px;margin:0 auto;background:var(--surface2)">
    <div class="card-head"><span class="card-title">Order Quick View</span><button class="action-btn" onclick="closeOrderQuickView()"><i class="fa-solid fa-xmark"></i></button></div>
    <div style="padding:20px;font-size:.8rem;line-height:1.8">
      <p><strong>Order:</strong> <span id="qv-order"></span></p>
      <p><strong>Customer:</strong> <span id="qv-order-customer"></span></p>
      <p><strong>Email:</strong> <span id="qv-order-email"></span></p>
      <p><strong>Total:</strong> $<span id="qv-order-total"></span></p>
      <p><strong>Status:</strong> <span id="qv-order-status"></span></p>
      <p><strong>Date:</strong> <span id="qv-order-date"></span></p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openOrderQuickView(button){
  document.getElementById('qv-order').textContent = button.dataset.order || '';
  document.getElementById('qv-order-customer').textContent = button.dataset.customer || '';
  document.getElementById('qv-order-email').textContent = button.dataset.email || '';
  document.getElementById('qv-order-total').textContent = button.dataset.total || '';
  document.getElementById('qv-order-status').textContent = button.dataset.status || '';
  document.getElementById('qv-order-date').textContent = button.dataset.date || '';
  document.getElementById('order-quick-view').style.display = 'block';
}
function closeOrderQuickView(){ document.getElementById('order-quick-view').style.display = 'none'; }
</script>
@endpush
