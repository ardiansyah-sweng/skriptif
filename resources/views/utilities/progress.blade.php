@extends('layouts.app')

@section('title', 'Pelacak Masa Studi & Kritis')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .badge-alert { font-size: 12px; padding: 5px 12px; border-radius: 6px; font-weight: 500; }
    .alert-danger-custom { background-color: #fee2e2; color: #b91c1c; }
    .alert-warning-custom { background-color: #fef3c7; color: #d97706; }
</style>
@endpush

@section('content')
<div style="max-width: 1200px;">
    <div class="mb-4">
        <h1 class="main-title">Sistem Pelacak Mahasiswa Kritis</h1>
        <p class="sub-title">Memantau mahasiswa aktif yang memiliki skripsi disetujui, namun tidak tercatat melakukan bimbingan (update logbook) dalam 30 hari terakhir.</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation text-danger me-2"></i> Daftar Mahasiswa Tidak Aktif Bimbingan</h5>
                    <span class="badge bg-danger">{{ count($criticalStudents) }} Mahasiswa Terdeteksi</span>
                </div>

                @if(count($criticalStudents) > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Mahasiswa</th>
                                    <th style="width: 30%">Skripsi & Pembimbing</th>
                                    <th style="width: 20%">Bimbingan Terakhir</th>
                                    <th style="width: 15%">Status Inaktif</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criticalStudents as $item)
                                    @php
                                        $alertClass = $item['days_inactive'] >= 60 ? 'alert-danger-custom' : 'alert-warning-custom';
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item['student']->name }}</span>
                                            <div class="text-secondary small">{{ $item['student']->student_id }}</div>
                                            <div class="small text-muted">Angkatan {{ $item['student']->year_entrance }}</div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item['skripsi']->title }}</span>
                                            <div class="mt-1 small text-secondary">
                                                <i class="fa-solid fa-chalkboard-user me-1"></i> Pembimbing: {{ $item['skripsi']->supervisor->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($item['latest_date'])
                                                <div class="fw-bold">{{ $item['latest_date'] }}</div>
                                                <div class="text-secondary small">Tercatat di logbook</div>
                                            @else
                                                <span class="text-danger fw-bold"><i class="fa-solid fa-circle-exclamation me-1"></i> Belum Pernah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge-alert {{ $alertClass }}">
                                                @if($item['days_inactive'] === 999)
                                                    Belum Bimbingan
                                                @else
                                                    {{ $item['days_inactive'] }} Hari Pasif
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $item['student']->email }}?subject=Peringatan: Keaktifan Bimbingan Skripsi - {{ $item['student']->name }}&body=Halo {{ $item['student']->name }},%0D%0A%0D%0AKami memantau bahwa Anda belum memperbarui logbook bimbingan skripsi Anda dalam 30 hari terakhir. Silakan segera menghubungi dosen pembimbing Anda dan mengisi logbook bimbingan.%0D%0A%0D%0ATerima kasih." class="btn btn-outline-danger btn-sm text-nowrap">
                                                <i class="fa-regular fa-envelope me-1"></i> Hubungi
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <i class="fa-solid fa-face-smile text-success display-4 mb-3"></i>
                        <h5 class="fw-bold text-success">Luar Biasa! Semua Mahasiswa Aktif</h5>
                        <p class="text-secondary mb-0">Seluruh mahasiswa aktif bimbingan tercatat konsisten memperbarui logbook dalam kurun waktu kurang dari 30 hari.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
