@extends('layouts.app')

@section('title', 'Detail Log Book Bimbingan')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; font-weight: 600; font-size: 15px; }
    .detail-section { padding: 24px; }
    .detail-row { display: flex; padding: 14px 0; border-bottom: 1px solid #f1f5f9; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { width: 200px; flex-shrink: 0; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
    .detail-value { font-size: 15px; color: #0f172a; font-weight: 500; word-break: break-word; flex: 1; }
    .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; text-transform: capitalize; }
    .status-pending  { background-color: #fef3c7; color: #d97706; }
    .status-approved { background-color: #dcfce7; color: #15803d; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; }
    .feedback-box { background: #f8fafc; border-left: 4px solid #3b82f6; border-radius: 8px; padding: 16px; margin-top: 8px; white-space: pre-line; font-size: 14px; }
    .activity-text { white-space: pre-line; font-size: 14px; line-height: 1.7; }
    .btn-back { background-color: transparent; color: #64748b; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; border-radius: 6px; padding: 10px 24px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-back:hover { background-color: #f1f5f9; color: #334155; }
    .btn-edit-action { background-color: #3b82f6; color: white; font-size: 14px; font-weight: 500; border-radius: 6px; padding: 10px 24px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-edit-action:hover { background-color: #2563eb; color: white; }
    .btn-print-action { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 8px 16px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-print-action:hover { background-color: #dc2626; color: white; }
    .crumb { font-size: 12px; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
    .crumb a { color: #64748b; text-decoration: none; }
    .crumb a:hover { color: #0f172a; }
    .attachment-preview { max-height: 300px; border-radius: 8px; border: 1px solid #e2e8f0; }
</style>
@endpush

@section('content')
    <div style="max-width: 860px;">
        <div class="crumb">
            <i class="fa-solid fa-house"></i>
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px;"></i>
            <a href="{{ route('log-books.index') }}">Log Book Bimbingan</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px;"></i>
            <span class="fw-semibold" style="color: #0f172a;">Detail</span>
        </div>

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Detail Catatan Bimbingan</h1>
                <p class="sub-title">Informasi lengkap sesi konsultasi bimbingan tugas akhir.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('log-books.edit', $logBook->id) }}" class="btn-edit-action">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <a href="{{ route('log-books.print', ['student_id' => $logBook->student_id]) }}" target="_blank" class="btn-print-action">
                    <i class="fa-solid fa-file-pdf"></i> Cetak Logbook
                </a>
                <a href="{{ route('log-books.index') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <i class="fa-solid fa-clipboard-list me-2 text-secondary"></i> Data Bimbingan
            </div>
            <div class="detail-section">
                <div class="detail-row">
                    <div class="detail-label">Mahasiswa</div>
                    <div class="detail-value">
                        <span class="fw-bold">{{ $logBook->student->name ?? '-' }}</span>
                        <span class="text-muted" style="font-weight: 400; font-size: 13px;">
                            (NIM. {{ $logBook->student->student_id ?? '-' }})
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Dosen Pembimbing</div>
                    <div class="detail-value">
                        <span>{{ $logBook->lecturer->name ?? '-' }}</span>
                        @if($logBook->lecturer && $logBook->lecturer->email)
                            <span class="text-muted" style="font-weight: 400; font-size: 13px;">
                                — {{ $logBook->lecturer->email }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Bimbingan</div>
                    <div class="detail-value">
                        {{ $logBook->date ? $logBook->date->format('d F Y') : '-' }}
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($logBook->status == 'pending')
                            <span class="badge-status status-pending"><i class="fa-solid fa-spinner fa-spin"></i> Pending</span>
                        @elseif($logBook->status == 'approved')
                            <span class="badge-status status-approved"><i class="fa-solid fa-circle-check"></i> Approved</span>
                        @else
                            <span class="badge-status status-rejected"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Aktivitas</div>
                    <div class="detail-value">
                        <div class="activity-text">{{ $logBook->activity }}</div>
                    </div>
                </div>
                @if($logBook->feedback)
                <div class="detail-row">
                    <div class="detail-label">Feedback Dosen</div>
                    <div class="detail-value">
                        <div class="feedback-box">
                            <i class="fa-solid fa-comment-dots text-primary me-1"></i>
                            {{ $logBook->feedback }}
                        </div>
                    </div>
                </div>
                @endif
                @if($logBook->attachment)
                <div class="detail-row">
                    <div class="detail-label">Lampiran</div>
                    <div class="detail-value">
                        @if(\Illuminate\Support\Str::endsWith(strtolower($logBook->attachment), '.pdf'))
                            <div class="d-flex align-items-center gap-3 p-3 rounded bg-light border" style="max-width: 400px;">
                                <i class="fa-solid fa-file-pdf text-danger" style="font-size: 32px;"></i>
                                <div>
                                    <a href="{{ asset('storage/' . $logBook->attachment) }}" target="_blank" class="fw-semibold text-dark text-decoration-none d-block" style="font-size: 14px;">
                                        Lihat Dokumen PDF
                                    </a>
                                    <span class="text-muted" style="font-size: 12px;">Berkas Lampiran Bimbingan</span>
                                </div>
                            </div>
                        @else
                            <div>
                                <a href="{{ asset('storage/' . $logBook->attachment) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $logBook->attachment) }}" alt="Lampiran Bimbingan" class="attachment-preview img-fluid">
                                </a>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $logBook->attachment) }}" target="_blank" class="text-primary text-decoration-none fw-semibold" style="font-size: 13px;">
                                        <i class="fa-solid fa-external-link-alt"></i> Buka gambar di tab baru
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('log-books.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('log-books.edit', $logBook->id) }}" class="btn-edit-action">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Catatan
                </a>
            </div>
        </div>
    </div>
@endsection
