@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Semua Notifikasi</span>
        @if(Auth::user()->unreadNotifications->count() > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
            @csrf
            <button class="btn btn-sm btn-outline-secondary" type="submit">Tandai semua dibaca</button>
        </form>
        @endif
    </div>
    <div class="list-group list-group-flush">
        @forelse($notifications as $notification)
            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action py-3 {{ $notification->read_at ? '' : 'bg-light' }}" style="text-align:left; width:100%; border:none; border-bottom:1px solid #eee;">
                    <div class="fw-semibold">{{ $notification->data['title'] ?? 'Notifikasi' }}</div>
                    <div class="text-muted small">{{ $notification->data['message'] ?? '' }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $notification->created_at->diffForHumans() }}</div>
                </button>
            </form>
        @empty
            <div class="text-muted text-center py-5">Belum ada notifikasi.</div>
        @endforelse
    </div>
</div>

<div class="mt-3">
    {{ $notifications->links() }}
</div>
@endsection
