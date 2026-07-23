@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    :root {
        --soft-blue: #4a7cbf;
        --soft-green: #4a9c6f;
        --soft-teal: #4a9ca8;
        --soft-purple: #7a6fa8;
        --soft-coral: #c27a7a;
        --soft-amber: #b8944a;
        --soft-slate: #6a7a8a;
        --soft-rose: #b87a8a;
        --soft-cyan: #5a8a9a;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card {
        cursor: default;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 130px;
        display: flex;
        align-items: center;
    }
    .stat-card:hover {
        transform: translateY(-6px) scale(1.02);
    }
    .stat-card .stat-overlay {
        position: absolute;
        top: -50%;
        right: -20%;
        font-size: 120px;
        opacity: 0.06;
        color: #fff;
        pointer-events: none;
    }
    .stat-card .stat-content {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 1.25rem;
    }
    .stat-card .stat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        flex-shrink: 0;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
    }
    .stat-card .stat-label {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.85);
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .welcome-banner {
        background: var(--soft-blue);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 350px;
        height: 350px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 20%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .welcome-banner h2 {
        font-size: 1.75rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    .welcome-banner p {
        font-size: 1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    .welcome-banner .welcome-icon {
        font-size: 64px;
        opacity: 0.15;
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .table thead th {
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table tbody tr {
        transition: background 0.2s;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .quick-action-btn {
        border-radius: 12px;
        padding: 0.7rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1.5px solid transparent;
    }
    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 1rem;
        padding: 0;
    }
    .section-header i {
        font-size: 1.1rem;
    }

    .counter-animate {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.6s ease forwards;
    }
    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .counter-animate:nth-child(1) { animation-delay: 0.05s; }
    .counter-animate:nth-child(2) { animation-delay: 0.1s; }
    .counter-animate:nth-child(3) { animation-delay: 0.15s; }
    .counter-animate:nth-child(4) { animation-delay: 0.2s; }
    .counter-animate:nth-child(5) { animation-delay: 0.25s; }
    .counter-animate:nth-child(6) { animation-delay: 0.3s; }
    .counter-animate:nth-child(7) { animation-delay: 0.35s; }
    .counter-animate:nth-child(8) { animation-delay: 0.4s; }
    .counter-animate:nth-child(9) { animation-delay: 0.45s; }
    .counter-animate:nth-child(10) { animation-delay: 0.5s; }

    .progress-ring {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    .progress-ring .ring {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .ring-pending { background: #ffc107; }
    .ring-approved { background: #198754; }
    .ring-rejected { background: #dc3545; }

    .card-header-table {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="welcome-banner text-white mb-4">
    <h2>Dashboard Sistem Informasi Skripsi</h2>
    <p class="mb-0">Ringkasan data akademik secara real-time.</p>
    <i class="fa-solid fa-chart-pie welcome-icon"></i>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-blue);">
            <div class="stat-overlay"><i class="fa-solid fa-user-graduate"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalStudents }}">0</div>
                    <div class="stat-label">Mahasiswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-green);">
            <div class="stat-overlay"><i class="fa-solid fa-chalkboard-user"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalLecturers }}">0</div>
                    <div class="stat-label">Dosen</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-teal);">
            <div class="stat-overlay"><i class="fa-solid fa-file-lines"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalSkripsi }}">0</div>
                    <div class="stat-label">Total Skripsi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-amber);">
            <div class="stat-overlay"><i class="fa-solid fa-book"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalLogBooks }}">0</div>
                    <div class="stat-label">Log Book</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-purple);">
            <div class="stat-overlay"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalExamSchedules }}">0</div>
                    <div class="stat-label">Jadwal Sidang</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-cyan);">
            <div class="stat-overlay"><i class="fa-solid fa-book-open"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalElectiveCourses }}">0</div>
                    <div class="stat-label">MK Pilihan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: #185FA5;">
            <div class="stat-overlay"><i class="fa-solid fa-clipboard-check"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalEvaluations }}">0</div>
                    <div class="stat-label">Evaluasi Skripsi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-rose);">
            <div class="stat-overlay"><i class="fa-solid fa-bullhorn"></i></div>
            <div class="stat-content d-flex align-items-center gap-3">
                <div class="stat-icon-box" style="background: rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <div class="stat-number" data-target="{{ $totalAnnouncements }}">0</div>
                    <div class="stat-label">Pengumuman</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 counter-animate">
        <div class="stat-card" style="background: var(--soft-slate);">
            <div class="stat-overlay"><i class="fa-solid fa-layer-group"></i></div>
            <div class="stat-content">
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="stat-label"><span class="ring ring-pending d-inline-block me-1"></span>Pending</span>
                        <span class="stat-number" style="font-size:1.1rem;" data-target="{{ $skripsiPending }}">0</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="stat-label"><span class="ring ring-approved d-inline-block me-1"></span>Approved</span>
                        <span class="stat-number" style="font-size:1.1rem;" data-target="{{ $skripsiApproved }}">0</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="stat-label"><span class="ring ring-rejected d-inline-block me-1"></span>Rejected</span>
                        <span class="stat-number" style="font-size:1.1rem;" data-target="{{ $skripsiRejected }}">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-table">
                <span class="section-header"><i class="fa-solid fa-file-lines text-primary"></i> Skripsi Terbaru</span>
                <a href="{{ route('skripsi.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Judul</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSkripsi as $s)
                            <tr>
                                <td class="fw-medium">{{ $s->student->name ?? '-' }}</td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $s->title }}">
                                        {{ $s->title }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $s->status == 'approved' ? 'success' : ($s->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($s->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data skripsi.
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
            <div class="card-header-table">
                <span class="section-header"><i class="fa-solid fa-book text-success"></i> Log Book Terbaru</span>
                <a href="{{ route('log-books.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Pembimbing</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogBooks as $lb)
                            <tr>
                                <td class="fw-medium">{{ $lb->student->name ?? '-' }}</td>
                                <td>{{ $lb->lecturer->name ?? '-' }}</td>
                                <td>{{ isset($lb->log_date) ? \Carbon\Carbon::parse($lb->log_date)->format('d/m/Y') : $lb->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data log book.
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

<div class="row g-4 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header-table">
                <span class="section-header"><i class="fa-solid fa-clipboard-check text-info"></i> Evaluasi Skripsi Terbaru</span>
                <a href="{{ route('evaluations.index') }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Dosen Penilai</th>
                                <th>Peran</th>
                                <th>Nilai Akhir</th>
                                <th>Tanggal Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEvaluations as $ev)
                            <tr>
                                <td class="fw-medium">{{ $ev->skripsi->student->name ?? '-' }}</td>
                                <td>{{ $ev->lecturer->name ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($ev->role ?? 'penilai') }}</span></td>
                                <td><span class="fw-bold text-primary">{{ $ev->final_score ?? $ev->score }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($ev->evaluation_date)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data evaluasi skripsi.
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
            <div class="card-header-table">
                <span class="section-header"><i class="fa-solid fa-bolt text-warning"></i> Aksi Cepat</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('evaluations.index') }}" class="btn btn-outline-primary quick-action-btn">
                        <i class="fa-solid fa-clipboard-check me-1"></i> Evaluasi Skripsi
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary quick-action-btn">
                        <i class="fa-solid fa-user-graduate me-1"></i> Mahasiswa
                    </a>
                    <a href="{{ route('lecturers.index') }}" class="btn btn-outline-success quick-action-btn">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Dosen
                    </a>
                    <a href="{{ route('skripsi.index') }}" class="btn btn-outline-info quick-action-btn">
                        <i class="fa-solid fa-file-lines me-1"></i> Skripsi
                    </a>
                    <a href="{{ route('log-books.index') }}" class="btn btn-outline-secondary quick-action-btn">
                        <i class="fa-solid fa-book me-1"></i> Log Book
                    </a>
                    <a href="{{ route('exam-schedules.index') }}" class="btn btn-outline-warning quick-action-btn">
                        <i class="fa-solid fa-calendar-check me-1"></i> Jadwal Sidang
                    </a>
                    <a href="{{ route('elective-courses.index') }}" class="btn btn-outline-danger quick-action-btn">
                        <i class="fa-solid fa-book-open me-1"></i> MK Pilihan
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

@push('scripts')
<script>
(function() {
    function animateCounter(el, target, duration) {
        let start = 0;
        let step = Math.ceil(target / (duration / 16));
        let timer = setInterval(function() {
            start += step;
            if (start >= target) {
                start = target;
                clearInterval(timer);
            }
            el.textContent = start;
        }, 16);
    }

    var numbers = document.querySelectorAll('.stat-number[data-target]');
    if (numbers.length) {
        numbers.forEach(function(el) {
            var target = parseInt(el.getAttribute('data-target'));
            if (target > 0) {
                animateCounter(el, target, 800);
            }
        });
    }
})();
</script>
@endpush
