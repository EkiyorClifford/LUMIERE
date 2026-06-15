@extends('layouts.admin')

@section('title', 'Collection Contents')
@section('page-title', 'Collection Pages')

@section('content')
<div class="page-header">
    <div>
        <p class="page-eyebrow">CATALOGUE</p>
        <h1 class="page-title">Collection Pages</h1>
    </div>
    <a href="{{ route('admin.collection-contents.create') }}" class="btn btn-gold">
        <i class="fa-solid fa-plus"></i>
        Add
    </a>
</div>

@if(session('success'))
    <div class="card" style="border-color: rgba(76, 175, 125, 0.2); padding: 14px 20px; color: var(--green); font-size: 0.72rem; letter-spacing: 0.08em;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-head">
        <h2 class="card-title">Editorial Content</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Slug</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contents as $content)
                <tr>
                    <td>{{ $content->slug }}</td>
                    <td>{{ $content->title }}</td>
                    <td>
                        <span class="badge {{ $content->is_active ? 'badge-green' : 'badge-red' }}">
                            <span class="dot {{ $content->is_active ? 'dot-green' : 'dot-red' }}"></span>
                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.collection-contents.edit', $content) }}" class="action-btn" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.collection-contents.toggle-active', $content) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn" title="Toggle active">
                                    <i class="fa-solid fa-power-off"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.collection-contents.destroy', $content) }}" method="POST" onsubmit="return confirm('Delete this collection content?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fa-solid fa-file-pen"></i>
                            <p>No collection page content entries found.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
