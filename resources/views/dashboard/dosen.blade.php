@extends('layouts.app')

@section('title', 'Dashboard Dosen')

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
    .quick-action-btn { border-radius: 12px; padding: 0.7rem 1.2rem; font-weight: 500; transition: all 0.3s ease; }
    .quick-action-btn:hover { transform: translateY(-2px); }
</style>
@endpush

@section('content')
<div class="welcome-banner text-white mb-4">
    <h2>Selamat Datang, {{ $lecturer->name ?? Auth::user()->name }}</h2>
    <p class="mb-0">Dashboard Dosen — Pantau bimbingan dan jadwal sidang mahasiswa.</p>
    <i class="fa-solid fa-chalkboard-user welcome-icon"></i>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: #4a7cbf;">
            <div class="stat-number">{{ $bimbinganCount }}</div>
            <div class="stat-label">Mahasiswa Bimbingan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: #4a9c6f;">
            <div class="stat-number">{{ $upcomingSchedules->count() }}</div>
            <div class="stat-label">Jadwal Sidang Mendatang</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: #7a6fa8;">
            <div class="stat-number">{{ $totalAnnouncements }}</div>
            <div class="stat-label">Pengumuman</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-calendar-check text-warning"></i> Jadwal Sidang Mendatang</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingSchedules as $s)
                            <tr>
                                <td class="fw-medium">{{ $s->skripsi->student->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_sidang)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $s->ruang }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada jadwal sidang mendatang.
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
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogBooks as $lb)
                            <tr>
                                <td class="fw-medium">{{ $lb->student->name ?? '-' }}</td>
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

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-bolt text-warning"></i> Aksi Cepat</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('log-books.index') }}" class="btn btn-outline-success quick-action-btn">
                        <i class="fa-solid fa-book me-1"></i> Log Book
                    </a>
                    <a href="{{ route('exam-schedules.index') }}" class="btn btn-outline-warning quick-action-btn">
                        <i class="fa-solid fa-calendar-check me-1"></i> Jadwal Sidang
                    </a>
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-dark quick-action-btn">
                        <i class="fa-solid fa-bullhorn me-1"></i> Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
