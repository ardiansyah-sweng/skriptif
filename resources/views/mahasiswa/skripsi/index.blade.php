@extends('layouts.app')

@section('title', 'Daftar Skripsi')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Pengajuan Skripsi</h5>
            </div>
            <div class="card-body p-0">
                @if(isset($skripsis) && $skripsis->count())
                    <ul class="list-group list-group-flush">
                        @foreach($skripsis as $item)
                            <li class="list-group-item">
                                <a href="{{ route('student.skripsi.show', $item->id) }}" class="text-decoration-none text-dark">
                                    <strong>{{ $item->title }}</strong><br>
                                    <small class="text-muted">Pembimbing: {{ $item->supervisor->name ?? '-' }}</small><br>
                                    <small class="text-muted">Status: {{ ucfirst($item->status) }}</small>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3 text-muted">Belum ada data skripsi.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Detail Skripsi</h5>
            </div>
            <div class="card-body">
                @if(isset($skripsi) && $skripsi)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul</label>
                        <div>{{ $skripsi->title }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <div>{{ $skripsi->description }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pembimbing</label>
                        <div>{{ $skripsi->supervisor->name ?? '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div>{{ ucfirst($skripsi->status) }}</div>
                    </div>
                @else
                    <div class="text-muted">Silakan pilih salah satu skripsi untuk melihat detail.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
