{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\users\show.blade.php --}}
@extends('layouts.admin')
@section('title', 'LUMIÈRE · Customer')
@section('page-title', 'Customer')
@section('content')
<div class="page active" id="page-customers"><div class="page-header"><div><div class="page-eyebrow">PEOPLE</div><h1 class="page-title">{{ $user->name }}</h1></div><a class="btn btn-outline" href="{{ route('admin.users.index') }}">BACK</a></div>
<div class="two-col"><div class="card"><div class="card-head"><span class="card-title">Profile</span></div><div style="padding:24px;font-size:0.78rem;color:var(--text-mid);line-height:1.9"><p><strong style="color:var(--text)">Email:</strong> {{ $user->email }}</p><p><strong style="color:var(--text)">Phone:</strong> {{ $user->phone ?? '—' }}</p><p><strong style="color:var(--text)">Membership:</strong> {{ str($user->membership_tier)->replace('_', ' ')->title() }}</p></div></div><div class="card"><div class="card-head"><span class="card-title">Orders</span></div><table><thead><tr><th>ORDER</th><th>TOTAL</th><th>STATUS</th></tr></thead><tbody>@forelse($user->orders as $order)<tr><td style="color:var(--text)">{{ $order->order_number ?? '#'.$order->id }}</td><td style="color:var(--gold)">${{ number_format($order->total, 2) }}</td><td><span class="badge badge-gold">{{ ucfirst($order->order_status) }}</span></td></tr>@empty<tr><td colspan="3"><div class="empty-state"><i class="fa-solid fa-bag-shopping"></i><p>No orders yet.</p></div></td></tr>@endforelse</tbody></table></div></div></div>
@endsection
