@extends('layouts.app')

@section('title', 'Riwayat Aplikasi Topik')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-start">
    <div>
        <h1 class="main-title">Riwayat Aplikasi Topik</h1>
        <p class="text-muted">Lihat pengajuan topik aplikasi dan status persetujuannya.</p>
    </div>
    <a href="{{ route('topic-board.index') }}" class="btn btn-secondary">Lihat Board Topik</a>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Mahasiswa</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $index => $application)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $application->student?->name }} ({{ $application->student?->student_id }})</td>
                    <td>{{ $application->lecturerTopic->title }}</td>
                    <td>{{ ucfirst($application->status) }}</td>
                    <td>{{ $application->message ?? '-' }}</td>
                    <td>{{ $application->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada aplikasi topik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
