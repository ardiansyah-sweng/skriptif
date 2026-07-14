@extends('layouts.app')

@section('title', 'Detail Dosen')

@push('styles')
<style>
body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); padding: 32px; }
        .detail-label { font-size: 13px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .detail-value { font-size: 15px; color: #0f172a; font-weight: 500; }
        .detail-row { padding: 16px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .btn-back-custom { background-color: transparent; color: #64748b; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: 1px solid #e2e8f0; text-decoration: none; }
        .btn-back-custom:hover { background-color: #f1f5f9; color: #334155; }
        .btn-edit-action { background-color: #3b82f6; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: none; text-decoration: none; }
        .btn-edit-action:hover { background-color: #2563eb; color: white; }
</style>
@endpush

@section('content')

<div class="container py-5" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Detail Dosen</h1>
                <p class="sub-title">Informasi lengkap data dosen.</p>
            </div>
            <a href="{{ route('lecturers.index') }}" class="btn-back-custom">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="content-card">
            <div class="detail-row">
                <div class="detail-label">NIDN / ID Dosen</div>
                <div class="detail-value">{{ $lecturer->lecturer_id }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value">{{ $lecturer->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value"><i class="fa-solid fa-envelope me-1 text-muted"></i> {{ $lecturer->email }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Keahlian</div>
                <div class="detail-value">{{ $lecturer->expertise ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Maks. Mahasiswa per Angkatan</div>
                <div class="detail-value">{{ $lecturer->max_supervisors ?? 3 }} mahasiswa</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Terdaftar Sejak</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($lecturer->created_at)->translatedFormat('d F Y, H:i') }}</div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('lecturers.index') }}" class="btn-back-custom">Tutup</a>
                <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn-edit-action">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Dosen
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection