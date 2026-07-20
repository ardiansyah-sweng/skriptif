@extends('layouts.app')

@section('title', 'Jadwal Sidang Skripsi')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; }
    .meta-text { font-size: 12px; color: #64748b; }
    .badge-proposal { background: #eff6ff; color: #1d4ed8; }
    .badge-pendadaran { background: #dcfce7; color: #15803d; }
    .status-terjadwal { background-color: #eff6ff; color: #1d4ed8; }
    .status-selesai { background-color: #dcfce7; color: #15803d; }
    .status-dibatalkan { background-color: #fee2e2; color: #b91c1c; }
    .btn-add { background-color: #2563eb; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 8px 18px; border: none; text-decoration: none; }
    .btn-add:hover { background-color: #1d4ed8; color: white; }
    .btn-delete { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
    .btn-delete:hover { background-color: #dc2626; color: white; }
    .btn-detail { background-color: #0f172a; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 12px; border: none; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-detail:hover { background-color: #334155; color: white; }
</style>
@endpush

@section('content')
    <div style="max-width: 1200px;">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Jadwal Sidang Skripsi</h1>
                <p class="sub-title">Kelola penjadwalan sidang proposal dan pendadaran.</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal" style="border-radius: 8px; padding: 8px 18px; font-size: 14px; font-weight: 500;">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                    @if(request()->anyFilled(['nama', 'nim', 'dosen_penguji', 'tanggal', 'ruang']))
                        <span class="badge bg-primary ms-1" style="font-size: 10px;">
                            {{ collect([request('nama'), request('nim'), request('dosen_penguji'), request('tanggal'), request('ruang')])->filter()->count() }}
                        </span>
                    @endif
                </button>
                <a href="{{ route('exam-schedules.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Jadwal
                </a>
            </div>
        </div>

        @if(request()->anyFilled(['nama', 'nim', 'dosen_penguji', 'tanggal', 'ruang']))
        <div class="d-flex align-items-center gap-2 mb-3">
            <small class="text-muted">Filter aktif:</small>
            @foreach(['nama' => 'Nama', 'nim' => 'NIM', 'dosen_penguji' => 'Dosen Pembimbing', 'tanggal' => 'Tanggal', 'ruang' => 'Ruang'] as $key => $label)
                @if(request()->filled($key))
                <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-1" style="font-size: 12px; font-weight: 500; padding: 4px 10px;">
                    {{ $label }}: {{ request($key) }}
                </span>
                @endif
            @endforeach
            <a href="{{ route('exam-schedules.index') }}" class="btn btn-sm btn-outline-danger border-0" style="font-size: 12px;">
                <i class="fa-solid fa-times"></i> Hapus filter
            </a>
        </div>
        @endif

        <div class="content-card">
            <div class="card-header-custom">
                <span class="fw-bold text-dark">Daftar Jadwal Sidang</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 4%">No</th>
                            <th style="width: 16%">Mahasiswa / NIM</th>
                            <th style="width: 24%">Judul Skripsi</th>
                            <th style="width: 12%" class="text-center">Jenis Sidang</th>
                            <th style="width: 16%">Tanggal & Waktu</th>
                            <th style="width: 10%">Ruang</th>
                            <th style="width: 10%" class="text-center">Status</th>
                            <th style="width: 12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $key => $schedule)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $schedule->skripsi->student->name ?? '-' }}</div>
                                <div class="meta-text">NIM. {{ $schedule->skripsi->student->student_id ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $schedule->skripsi->title ?? '-' }}</div>
                                @if($schedule->skripsi->supervisor)
                                    <div class="meta-text mt-1 text-primary">
                                        <i class="fa-solid fa-user-tie me-1"></i> {{ $schedule->skripsi->supervisor->name }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($schedule->jenis_sidang === 'proposal')
                                    <span class="badge-status badge-proposal"><i class="fa-solid fa-file-lines"></i> Proposal</span>
                                @else
                                    <span class="badge-status badge-pendadaran"><i class="fa-solid fa-graduation-cap"></i> Pendadaran</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ $schedule->tanggal_sidang->format('d M Y') }}</div>
                                <div class="meta-text">{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</div>
                            </td>
                            <td>{{ $schedule->ruang }}</td>
                            <td class="text-center">
                                @if($schedule->status === 'terjadwal')
                                    <span class="badge-status status-terjadwal"><i class="fa-solid fa-calendar-check"></i> Terjadwal</span>
                                @elseif($schedule->status === 'selesai')
                                    <span class="badge-status status-selesai"><i class="fa-solid fa-check"></i> Selesai</span>
                                @else
                                    <span class="badge-status status-dibatalkan"><i class="fa-solid fa-xmark"></i> Dibatalkan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('exam-schedules.show', $schedule->id) }}" class="btn-detail mb-1" title="Lihat detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form action="{{ route('exam-schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal sidang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px;"></i>
                                Belum ada jadwal sidang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold" id="filterModalLabel">
                    <i class="fa-solid fa-filter me-2 text-primary"></i>Filter Jadwal Sidang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="GET" action="{{ route('exam-schedules.index') }}">
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted small">Nama Mahasiswa</label>
                        <input type="text" name="nama" class="form-control" placeholder="Cari nama mahasiswa..." value="{{ request('nama') }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" oninput="this.setCustomValidity(''); if(!this.validity.valid) this.setCustomValidity('Hanya huruf yang diizinkan')" style="border-radius: 8px; padding: 10px 14px; font-size: 14px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted small">NIM</label>
                        <input type="text" name="nim" class="form-control" placeholder="Cari NIM..." value="{{ request('nim') }}" pattern="[0-9]+" title="Hanya angka yang diizinkan" oninput="this.setCustomValidity(''); if(!this.validity.valid) this.setCustomValidity('Hanya angka yang diizinkan')" style="border-radius: 8px; padding: 10px 14px; font-size: 14px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted small">Dosen Pembimbing</label>
                        <input type="text" name="dosen_penguji" class="form-control" placeholder="Cari nama dosen..." value="{{ request('dosen_penguji') }}" style="border-radius: 8px; padding: 10px 14px; font-size: 14px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted small">Tanggal Sidang</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" style="border-radius: 8px; padding: 10px 14px; font-size: 14px;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-medium text-muted small">Ruangan</label>
                        <input type="text" name="ruang" class="form-control" placeholder="Cari ruangan..." value="{{ request('ruang') }}" style="border-radius: 8px; padding: 10px 14px; font-size: 14px;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                    <a href="{{ route('exam-schedules.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 8px 18px; font-size: 14px; font-weight: 500;">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 8px 18px; font-size: 14px; font-weight: 500;">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
