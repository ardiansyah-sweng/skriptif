@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@push('styles')
<style>
    .welcome-banner {
        background: #185FA5;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%; right: -10%;
        width: 350px; height: 350px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-banner h2 { font-size: 1.75rem; font-weight: 700; position: relative; z-index: 1; }
    .welcome-banner p { font-size: 1rem; opacity: 0.9; position: relative; z-index: 1; }
    .welcome-banner .welcome-icon {
        font-size: 64px; opacity: 0.15;
        position: absolute; right: 2rem; top: 50%; transform: translateY(-50%);
    }
    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
    .stat-card .stat-number { font-size: 2rem; font-weight: 800; line-height: 1.1; }
    .stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; font-weight: 500; }
    .card { border: none; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .card-header-custom {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem; border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 600;
    }
    .table thead th { border-bottom: 2px solid #e9ecef; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; }
    .detail-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; background: #ffffff; height: 100%; }
    .detail-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .detail-value { font-size: 15px; font-weight: 600; color: #0f172a; }
</style>
@endpush

@section('content')
<div class="welcome-banner text-white mb-4">
    <h2>Selamat Datang, {{ $student->name ?? Auth::user()->name }}</h2>
    <p class="mb-0">Dashboard Mahasiswa — Pantau progress skripsi Anda.</p>
    <i class="fa-solid fa-user-graduate welcome-icon"></i>
</div>

@if($skripsi)
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: #4a7cbf;">
            <div class="stat-number">{{ ucfirst($skripsi->status) }}</div>
            <div class="stat-label">Status Skripsi</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: #4a9c6f;">
            <div class="stat-number">{{ $schedules->count() }}</div>
            <div class="stat-label">Jadwal Sidang</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: #7a6fa8;">
            <div class="stat-number">{{ $recentLogBooks->count() }}</div>
            <div class="stat-label">Log Book</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="detail-box">
            <div class="detail-label">Judul Skripsi</div>
            <div class="detail-value">{{ $skripsi->title }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="detail-box">
            <div class="detail-label">Dosen Pembimbing</div>
            <div class="detail-value">{{ $skripsi->supervisor->name ?? '-' }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="detail-box">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="badge rounded-pill bg-{{ $skripsi->status === 'approved' ? 'success' : ($skripsi->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($skripsi->status) }}
                </span>
            </div>
        </div>
    </div>
</div>
@else
<div class="card mb-4">
    <div class="card-body text-center py-5">
        <i class="fa-solid fa-file-lines fs-1 text-muted mb-3"></i>
        <h5>Belum ada pengajuan skripsi</h5>
        <p class="text-muted mb-3">Ajukan proposal skripsi Anda untuk memulai.</p>
        <a href="{{ route('student.skripsi.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Ajukan Skripsi
        </a>
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-calendar-check text-warning"></i> Jadwal Sidang</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $s)
                            <tr>
                                <td>{{ ucfirst($s->jenis_sidang) }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_sidang)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $s->ruang }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $s->status === 'selesai' ? 'success' : ($s->status === 'terjadwal' ? 'primary' : 'danger') }}">
                                        {{ ucfirst($s->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
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

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-book text-success"></i> Log Book Terbaru</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Dosen</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogBooks as $lb)
                            <tr>
                                <td>{{ $lb->lecturer->name ?? '-' }}</td>
                                <td>{{ $lb->date ? \Carbon\Carbon::parse($lb->date)->format('d/m/Y') : $lb->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $lb->status === 'approved' ? 'success' : ($lb->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($lb->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada log book.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
