{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\users\index.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Customers')
@section('page-title', 'Customers')
@section('content')
<div class="page active" id="page-customers">
  <div class="page-header"><div><div class="page-eyebrow">PEOPLE</div><h1 class="page-title">Customers</h1></div></div>
  <div class="card">
    <table>
      <thead><tr><th>NAME</th><th>EMAIL</th><th>MEMBERSHIP</th><th>CONSULTANT</th><th>STATUS</th><th>JOINED</th><th>ACTIONS</th></tr></thead>
      <tbody>
        @forelse($users as $user)
          <tr>
            <td style="color:var(--text)">{{ $user->name }}</td><td>{{ $user->email }}</td>
            <td><span class="badge badge-gold">{{ str($user->membership_tier)->replace('_', ' ')->title() }}</span></td>
            <td>{{ $user->consultant?->name ?? '—' }}</td>
            <td><span id="user-status-{{ $user->id }}" class="badge {{ $user->is_active ? 'badge-green' : 'badge-dim' }}">{{ $user->is_active ? 'Active' : 'Disabled' }}</span></td>
            <td style="color:var(--text-dim)">{{ $user->created_at->format('M d, Y') }}</td>
            <td><div class="action-group"><button class="action-btn" title="Quick view" data-name="{{ e($user->name) }}" data-email="{{ e($user->email) }}" data-membership="{{ e(str($user->membership_tier)->replace('_', ' ')->title()) }}" data-consultant="{{ e($user->consultant?->name ?? '—') }}" data-status="{{ $user->is_active ? 'Active' : 'Disabled' }}" data-joined="{{ $user->created_at->format('M d, Y H:i') }}" onclick="openUserQuickView(this)"><i class="fa-solid fa-expand"></i></button><button class="action-btn danger" title="Toggle account" onclick="toggleUserActive({{ $user->id }})"><i class="fa-solid fa-power-off"></i></button><a class="action-btn" href="{{ route('admin.users.show', $user) }}" title="View profile"><i class="fa-solid fa-user"></i></a></div></td>
          </tr>
        @empty
          <tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-users"></i><p>No customers yet.<br>Customer accounts will appear here.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $users->links() }}
</div>

<div id="user-quick-view" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1000;padding:40px;">
  <div class="card" style="max-width:700px;margin:0 auto;background:var(--surface2)">
    <div class="card-head"><span class="card-title">Customer Quick View</span><button class="action-btn" onclick="closeUserQuickView()"><i class="fa-solid fa-xmark"></i></button></div>
    <div style="padding:20px;font-size:.8rem;line-height:1.8">
      <p><strong>Name:</strong> <span id="qv-user-name"></span></p>
      <p><strong>Email:</strong> <span id="qv-user-email"></span></p>
      <p><strong>Membership:</strong> <span id="qv-user-membership"></span></p>
      <p><strong>Consultant:</strong> <span id="qv-user-consultant"></span></p>
      <p><strong>Status:</strong> <span id="qv-user-status"></span></p>
      <p><strong>Joined:</strong> <span id="qv-user-joined"></span></p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openUserQuickView(button){
  document.getElementById('qv-user-name').textContent = button.dataset.name || '';
  document.getElementById('qv-user-email').textContent = button.dataset.email || '';
  document.getElementById('qv-user-membership').textContent = button.dataset.membership || '';
  document.getElementById('qv-user-consultant').textContent = button.dataset.consultant || '';
  document.getElementById('qv-user-status').textContent = button.dataset.status || '';
  document.getElementById('qv-user-joined').textContent = button.dataset.joined || '';
  document.getElementById('user-quick-view').style.display = 'block';
}
function closeUserQuickView(){ document.getElementById('user-quick-view').style.display = 'none'; }

async function toggleUserActive(id){
  const res = await fetch(`/admin/users/${id}/toggle-active`, {
    method: 'PATCH',
    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
  });
  if (!res.ok) return;

  const data = await res.json();
  const badge = document.getElementById(`user-status-${id}`);
  if (!badge) return;

  badge.textContent = data.label;
  badge.className = `badge ${data.is_active ? 'badge-green' : 'badge-dim'}`;
}
</script>
@endpush
