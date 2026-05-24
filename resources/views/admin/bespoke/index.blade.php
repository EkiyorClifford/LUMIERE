{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\bespoke\index.blade.php --}}
@extends('layouts.admin')

@section('title', 'LUMIÈRE · Bespoke')
@section('page-title', 'Bespoke')

@section('content')
<div class="page active" id="page-bespoke">
  <div class="page-header">
    <div>
      <div class="page-eyebrow">COMMERCE</div>
      <h1 class="page-title">Bespoke Requests</h1>
    </div>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>CLIENT</th>
          <th>EMAIL</th>
          <th>STATUS</th>
          <th>INVITED</th>
          <th>SUBMITTED</th>
          <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        @forelse($requests as $requestItem)
          <tr>
            <td style="color:var(--text)">{{ $requestItem->name }}</td>
            <td>{{ $requestItem->email }}</td>
            <td>
              <span class="badge badge-gold">{{ ucfirst($requestItem->status ?? 'new') }}</span>
            </td>
            <td>{{ optional($requestItem->invited_at)->format('d M Y, H:i') ?? '—' }}</td>
            <td>{{ optional($requestItem->created_at)->format('d M Y, H:i') ?? '—' }}</td>
            <td>
              <button class="action-btn" title="Quick view"
                data-client="{{ e($requestItem->name) }}"
                data-email="{{ e($requestItem->email) }}"
                data-status="{{ e(ucfirst($requestItem->status ?? 'new')) }}"
                data-invited="{{ optional($requestItem->invited_at)->format('d M Y, H:i') ?? '—' }}"
                data-submitted="{{ optional($requestItem->created_at)->format('d M Y, H:i') ?? '—' }}"
                data-message="{{ e($requestItem->message ?? 'No message provided') }}"
                onclick="openBespokeQuickView(this)">
                <i class="fa-solid fa-expand"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <p>No bespoke requests yet.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $requests->links() }}
</div>

<div id="bespoke-quick-view" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:1000;padding:40px;">
  <div class="card" style="max-width:700px;margin:0 auto;background:var(--surface2)">
    <div class="card-head"><span class="card-title">Bespoke Quick View</span><button class="action-btn" onclick="closeBespokeQuickView()"><i class="fa-solid fa-xmark"></i></button></div>
    <div style="padding:20px;font-size:.8rem;line-height:1.8">
      <p><strong>Client:</strong> <span id="qv-bespoke-client"></span></p>
      <p><strong>Email:</strong> <span id="qv-bespoke-email"></span></p>
      <p><strong>Status:</strong> <span id="qv-bespoke-status"></span></p>
      <p><strong>Invited:</strong> <span id="qv-bespoke-invited"></span></p>
      <p><strong>Submitted:</strong> <span id="qv-bespoke-submitted"></span></p>
      <p><strong>Message:</strong><br><span id="qv-bespoke-message"></span></p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openBespokeQuickView(button){
  document.getElementById('qv-bespoke-client').textContent = button.dataset.client || '';
  document.getElementById('qv-bespoke-email').textContent = button.dataset.email || '';
  document.getElementById('qv-bespoke-status').textContent = button.dataset.status || '';
  document.getElementById('qv-bespoke-invited').textContent = button.dataset.invited || '';
  document.getElementById('qv-bespoke-submitted').textContent = button.dataset.submitted || '';
  document.getElementById('qv-bespoke-message').textContent = button.dataset.message || '';
  document.getElementById('bespoke-quick-view').style.display = 'block';
}
function closeBespokeQuickView(){ document.getElementById('bespoke-quick-view').style.display = 'none'; }
</script>
@endpush
