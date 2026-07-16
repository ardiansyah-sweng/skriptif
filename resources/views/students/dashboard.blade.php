@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@push('styles')
<style>
    /* ===== Color Tokens ===== */
    :root {
        --student-primary:    #2563eb;
        --student-secondary:  #7c3aed;
        --student-success:    #059669;
        --student-warning:    #d97706;
        --student-danger:     #dc2626;
        --student-info:       #0891b2;
        --student-dark:       #1e293b;
        --student-muted:      #64748b;
        --gradient-primary:   linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        --gradient-success:   linear-gradient(135deg, #059669 0%, #10b981 100%);
        --gradient-warning:   linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        --gradient-danger:    linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        --gradient-info:      linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
        --shadow-sm:   0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md:   0 4px 16px rgba(0,0,0,.08);
        --shadow-lg:   0 10px 40px rgba(0,0,0,.12);
        --radius-card: 18px;
    }

    /* ===== Welcome Banner ===== */
    .student-welcome {
        background: var(--gradient-primary);
        border-radius: var(--radius-card);
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        margin-bottom: 1.75rem;
    }
    .student-welcome::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 260px; height: 260px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
    }
    .student-welcome::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 10%;
        width: 200px; height: 200px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
    }
    .student-welcome .welcome-content { position: relative; z-index: 1; }
    .student-welcome .welcome-name {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: .25rem;
        letter-spacing: -.3px;
    }
    .student-welcome .welcome-meta {
        font-size: .9rem;
        opacity: .85;
        display: flex;
        gap: 1.25rem;
        flex-wrap: wrap;
    }
    .student-welcome .welcome-meta span {
        display: flex;
        align-items: center;
        gap: .35rem;
    }
    .student-welcome .welcome-bg-icon {
        position: absolute;
        right: 2rem; top: 50%;
        transform: translateY(-50%);
        font-size: 7rem;
        opacity: .08;
        z-index: 0;
    }

    /* ===== Stat Cards ===== */
    .stat-card-student {
        border-radius: var(--radius-card);
        padding: 1.4rem 1.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform .3s ease, box-shadow .3s ease;
        min-height: 110px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-card-student:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .stat-card-student .sc-bg-icon {
        position: absolute;
        top: -15px; right: -10px;
        font-size: 5rem;
        opacity: .12;
    }
    .stat-card-student .sc-label {
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        opacity: .85;
    }
    .stat-card-student .sc-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }
    .stat-card-student .sc-sub {
        font-size: .78rem;
        opacity: .8;
    }

    /* ===== Skripsi Status Card ===== */
    .skripsi-status-card {
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: box-shadow .3s;
    }
    .skripsi-status-card:hover { box-shadow: var(--shadow-lg); }
    .skripsi-status-card .ssc-header {
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(0,0,0,.06);
        font-weight: 700;
        font-size: .95rem;
        gap: .5rem;
    }
    .skripsi-status-card .ssc-body {
        padding: 1.5rem;
    }

    /* ===== Progress Timeline ===== */
    .progress-timeline {
        display: flex;
        align-items: flex-start;
        gap: 0;
        position: relative;
        padding: 1rem 0;
    }
    .pt-step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .pt-step::before {
        content: '';
        position: absolute;
        top: 18px;
        left: 50%;
        right: -50%;
        height: 3px;
        background: #e2e8f0;
        z-index: 0;
    }
    .pt-step:last-child::before { display: none; }
    .pt-step.done::before  { background: var(--student-success); }
    .pt-step.active::before { background: linear-gradient(to right, var(--student-success) 0%, #e2e8f0 100%); }

    .pt-dot {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        margin: 0 auto .6rem;
        position: relative;
        z-index: 1;
        transition: all .3s;
        border: 3px solid #fff;
        box-shadow: var(--shadow-sm);
    }
    .pt-step.done  .pt-dot   { background: var(--student-success); color: #fff; }
    .pt-step.active .pt-dot  {
        background: var(--student-primary);
        color: #fff;
        animation: pulse-dot 1.8s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,.4); }
        50%       { box-shadow: 0 0 0 8px rgba(37,99,235,0); }
    }
    .pt-label {
        font-size: .72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .pt-step.done  .pt-label  { color: var(--student-success); }
    .pt-step.active .pt-label { color: var(--student-primary); }

    /* ===== Section Cards ===== */
    .section-card {
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        background: #fff;
        border: none;
        transition: box-shadow .3s;
    }
    .section-card:hover { box-shadow: var(--shadow-lg); }
    .section-card .sc-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        font-size: .9rem;
    }
    .section-card .sc-head .head-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
        color: #fff;
    }
    .section-card .sc-body {
        padding: 1.25rem 1.4rem;
    }

    /* ===== Log Book Item ===== */
    .logbook-item {
        display: flex;
        align-items: flex-start;
        gap: .9rem;
        padding: .8rem 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background .2s;
    }
    .logbook-item:last-child { border-bottom: none; padding-bottom: 0; }
    .logbook-item:first-child { padding-top: 0; }
    .logbook-dot {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--gradient-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        flex-shrink: 0;
    }
    .logbook-content .lb-date {
        font-size: .72rem;
        color: var(--student-muted);
        font-weight: 500;
    }
    .logbook-content .lb-activity {
        font-size: .88rem;
        font-weight: 600;
        color: var(--student-dark);
        margin: .1rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .logbook-content .lb-lecturer {
        font-size: .75rem;
        color: var(--student-muted);
    }

    /* ===== Announcement Item ===== */
    .announce-item {
        display: flex;
        gap: .9rem;
        padding: .85rem 0;
        border-bottom: 1px solid #f1f5f9;
        align-items: flex-start;
    }
    .announce-item:last-child { border-bottom: none; padding-bottom: 0; }
    .announce-item:first-child { padding-top: 0; }
    .announce-dot {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--gradient-warning);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        flex-shrink: 0;
    }
    .announce-content .ann-date {
        font-size: .72rem;
        color: var(--student-muted);
    }
    .announce-content .ann-title {
        font-size: .88rem;
        font-weight: 600;
        color: var(--student-dark);
        margin: .1rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===== Exam Schedule ===== */
    .exam-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: .9rem;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: .75rem;
        transition: all .25s;
    }
    .exam-item:last-child { margin-bottom: 0; }
    .exam-item:hover { background: #eff6ff; border-color: #bfdbfe; }
    .exam-date-box {
        text-align: center;
        min-width: 52px;
        background: var(--gradient-primary);
        color: #fff;
        border-radius: 10px;
        padding: .5rem .4rem;
        flex-shrink: 0;
    }
    .exam-date-box .day  { font-size: 1.3rem; font-weight: 800; line-height: 1; }
    .exam-date-box .mon  { font-size: .65rem; text-transform: uppercase; opacity: .85; }
    .exam-info .ei-type  { font-size: .78rem; font-weight: 600; color: var(--student-primary); text-transform: uppercase; }
    .exam-info .ei-time  { font-size: .88rem; font-weight: 700; color: var(--student-dark); }
    .exam-info .ei-room  { font-size: .78rem; color: var(--student-muted); }

    /* ===== Quick Actions ===== */
    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: 1.1rem .75rem;
        border-radius: 14px;
        border: 2px solid #e2e8f0;
        background: #fff;
        color: var(--student-dark);
        text-decoration: none;
        font-size: .8rem;
        font-weight: 600;
        text-align: center;
        transition: all .25s ease;
        box-shadow: var(--shadow-sm);
    }
    .quick-btn .qb-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        transition: transform .25s;
    }
    .quick-btn:hover {
        border-color: var(--student-primary);
        color: var(--student-primary);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    .quick-btn:hover .qb-icon { transform: scale(1.1); }

    /* ===== Empty State ===== */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--student-muted);
    }
    .empty-state i {
        font-size: 2.5rem;
        opacity: .3;
        display: block;
        margin-bottom: .75rem;
    }
    .empty-state p { font-size: .9rem; margin: 0; }

    /* ===== Badge Status ===== */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .35rem .75rem;
        border-radius: 50px;
        font-size: .78rem;
        font-weight: 700;
    }
    .badge-status.pending   { background: #fef3c7; color: #92400e; }
    .badge-status.approved  { background: #d1fae5; color: #065f46; }
    .badge-status.rejected  { background: #fee2e2; color: #991b1b; }

    /* ===== Fade In Animation ===== */
    .fade-in-up {
        opacity: 0;
        transform: translateY(24px);
        animation: fadeInUp .5s ease forwards;
    }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    .delay-1 { animation-delay: .05s; }
    .delay-2 { animation-delay: .1s; }
    .delay-3 { animation-delay: .15s; }
    .delay-4 { animation-delay: .2s; }
    .delay-5 { animation-delay: .25s; }
    .delay-6 { animation-delay: .3s; }
</style>
@endpush

@section('content')

{{-- ===== Welcome Banner ===== --}}
<div class="student-welcome fade-in-up">
    <div class="welcome-content">
        <div class="welcome-name">
            <i class="fa-solid fa-hand-wave me-2" style="font-size:1.3rem;"></i>
            Halo, {{ $student->name ?? 'Mahasiswa' }}!
        </div>
        <div class="welcome-meta mt-2">
            <span><i class="fa-solid fa-id-card"></i> {{ $student->student_id ?? '-' }}</span>
            <span><i class="fa-solid fa-calendar"></i> Angkatan {{ $student->year_entrance ?? '-' }}</span>
            <span>
                <i class="fa-solid fa-circle-dot"></i>
                {{ $student->status === 'active' ? 'Aktif' : ucfirst($student->status ?? '-') }}
            </span>
        </div>
    </div>
    <i class="fa-solid fa-graduation-cap welcome-bg-icon"></i>
</div>

{{-- ===== Stat Cards Row ===== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3 fade-in-up delay-1">
        <div class="stat-card-student" style="background: var(--gradient-primary);">
            <i class="fa-solid fa-file-lines sc-bg-icon"></i>
            <div class="sc-label">Status Skripsi</div>
            <div>
                @if($skripsi)
                    <div class="sc-value" style="font-size:1.2rem; font-weight:800;">
                        {{ ucfirst($skripsi->status) }}
                    </div>
                    <div class="sc-sub mt-1">{{ \Illuminate\Support\Str::limit($skripsi->title, 30) }}</div>
                @else
                    <div class="sc-value" style="font-size:1.1rem;">Belum Ada</div>
                    <div class="sc-sub">Belum mengajukan skripsi</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 fade-in-up delay-2">
        <div class="stat-card-student" style="background: var(--gradient-success);">
            <i class="fa-solid fa-book sc-bg-icon"></i>
            <div class="sc-label">Total Log Book</div>
            <div>
                <div class="sc-value">{{ $totalLogBooks }}</div>
                <div class="sc-sub">Sesi bimbingan tercatat</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 fade-in-up delay-3">
        <div class="stat-card-student" style="background: var(--gradient-info);">
            <i class="fa-solid fa-calendar-check sc-bg-icon"></i>
            <div class="sc-label">Jadwal Sidang</div>
            <div>
                <div class="sc-value">{{ $examSchedules->count() }}</div>
                <div class="sc-sub">
                    @if($examSchedules->count() > 0)
                        Sidang terjadwal
                    @else
                        Belum ada sidang
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 fade-in-up delay-4">
        <div class="stat-card-student" style="background: var(--gradient-warning);">
            <i class="fa-solid fa-bullhorn sc-bg-icon"></i>
            <div class="sc-label">Pengumuman</div>
            <div>
                <div class="sc-value">{{ $announcements->count() }}</div>
                <div class="sc-sub">Pengumuman terbaru</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Skripsi Status + Progress Timeline ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-7 fade-in-up delay-2">
        <div class="skripsi-status-card section-card">
            <div class="ssc-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background: var(--gradient-primary);">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <span>Status Pengajuan Skripsi</span>
                </div>
                @if($skripsi)
                    <span class="badge-status {{ $skripsi->status }}">
                        @if($skripsi->status === 'pending')
                            <i class="fa-solid fa-clock"></i> Menunggu
                        @elseif($skripsi->status === 'approved')
                            <i class="fa-solid fa-circle-check"></i> Disetujui
                        @else
                            <i class="fa-solid fa-circle-xmark"></i> Ditolak
                        @endif
                    </span>
                @endif
            </div>
            <div class="ssc-body">
                @if($skripsi)
                    {{-- Progress Timeline --}}
                    @php
                        $step = 0;
                        if ($skripsi->status === 'pending')  $step = 1;
                        if ($skripsi->status === 'approved') $step = 2;
                        if ($examSchedules->count() > 0)     $step = 3;
                        if ($student->is_lulus)              $step = 4;
                    @endphp
                    <div class="progress-timeline mb-4">
                        <div class="pt-step {{ $step >= 1 ? 'done' : '' }} {{ $step === 0 ? 'active' : '' }}">
                            <div class="pt-dot"><i class="fa-solid fa-paper-plane"></i></div>
                            <div class="pt-label">Diajukan</div>
                        </div>
                        <div class="pt-step {{ $step >= 2 ? 'done' : '' }} {{ $step === 1 ? 'active' : '' }}">
                            <div class="pt-dot"><i class="fa-solid fa-check"></i></div>
                            <div class="pt-label">Disetujui</div>
                        </div>
                        <div class="pt-step {{ $step >= 3 ? 'done' : '' }} {{ $step === 2 ? 'active' : '' }}">
                            <div class="pt-dot"><i class="fa-solid fa-calendar"></i></div>
                            <div class="pt-label">Sidang</div>
                        </div>
                        <div class="pt-step {{ $step >= 4 ? 'done' : '' }} {{ $step === 3 ? 'active' : '' }}">
                            <div class="pt-dot"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div class="pt-label">Lulus</div>
                        </div>
                    </div>

                    {{-- Skripsi Detail --}}
                    <div class="row g-2">
                        <div class="col-12">
                            <div style="background:#f8fafc; border-radius:12px; padding:1rem;">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.5px; color:var(--student-muted); font-weight:600;">Judul Skripsi</div>
                                        <div style="font-size:.92rem; font-weight:700; color:var(--student-dark); margin-top:.2rem;">
                                            {{ $skripsi->title }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.5px; color:var(--student-muted); font-weight:600;">Dosen Pembimbing</div>
                                        <div style="font-size:.88rem; font-weight:600; color:var(--student-dark); margin-top:.2rem;">
                                            <i class="fa-solid fa-chalkboard-user me-1 text-primary"></i>
                                            {{ $skripsi->supervisor->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.5px; color:var(--student-muted); font-weight:600;">Tanggal Pengajuan</div>
                                        <div style="font-size:.88rem; font-weight:600; color:var(--student-dark); margin-top:.2rem;">
                                            <i class="fa-regular fa-calendar me-1 text-primary"></i>
                                            {{ $skripsi->submission_date ? $skripsi->submission_date->format('d M Y') : '-' }}
                                        </div>
                                    </div>
                                    @if($skripsi->status === 'rejected' && $skripsi->rejection_note)
                                    <div class="col-12">
                                        <div style="background:#fee2e2; border-radius:10px; padding:.75rem 1rem; font-size:.85rem; color:#991b1b;">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                            <strong>Catatan Penolakan:</strong> {{ $skripsi->rejection_note }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                        <p>Belum ada pengajuan skripsi.</p>
                        <a href="{{ route('student.skripsi.create') }}" class="btn btn-primary btn-sm mt-2 rounded-pill px-4">
                            <i class="fa-solid fa-plus me-1"></i> Ajukan Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== Jadwal Sidang ===== --}}
    <div class="col-lg-5 fade-in-up delay-3">
        <div class="section-card h-100">
            <div class="sc-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background: var(--gradient-info);">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <span>Jadwal Sidang</span>
                </div>
            </div>
            <div class="sc-body">
                @forelse($examSchedules as $exam)
                    <div class="exam-item">
                        <div class="exam-date-box">
                            <div class="day">{{ $exam->tanggal_sidang->format('d') }}</div>
                            <div class="mon">{{ $exam->tanggal_sidang->format('M Y') }}</div>
                        </div>
                        <div class="exam-info">
                            <div class="ei-type">{{ $exam->jenis_sidang }}</div>
                            <div class="ei-time">
                                {{ \Carbon\Carbon::parse($exam->jam_mulai)->format('H:i') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($exam->jam_selesai)->format('H:i') }}
                            </div>
                            <div class="ei-room"><i class="fa-solid fa-location-dot me-1"></i>{{ $exam->ruang ?? '-' }}</div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge rounded-pill {{ $exam->status === 'selesai' ? 'bg-success' : ($exam->status === 'batal' ? 'bg-danger' : 'bg-primary') }}" style="font-size:.7rem;">
                                {{ ucfirst($exam->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        <p>Belum ada jadwal sidang.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===== Log Book + Pengumuman ===== --}}
<div class="row g-4 mb-4">
    {{-- Log Book Terbaru --}}
    <div class="col-lg-6 fade-in-up delay-4">
        <div class="section-card">
            <div class="sc-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background: var(--gradient-success);">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <span>Log Book Bimbingan Terbaru</span>
                </div>
                <a href="{{ route('log-books.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size:.75rem;">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="sc-body">
                @forelse($logBooks as $lb)
                    <div class="logbook-item">
                        <div class="logbook-dot">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div class="logbook-content flex-1">
                            <div class="lb-date">
                                {{ $lb->date ? $lb->date->format('d M Y') : $lb->created_at->format('d M Y') }}
                            </div>
                            <div class="lb-activity">{{ $lb->activity ?? 'Bimbingan' }}</div>
                            <div class="lb-lecturer">
                                <i class="fa-solid fa-chalkboard-user me-1"></i>
                                {{ $lb->lecturer->name ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <span class="badge rounded-pill {{ $lb->status === 'disetujui' ? 'bg-success' : ($lb->status === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size:.68rem;">
                                {{ ucfirst($lb->status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <p>Belum ada log book bimbingan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pengumuman Terbaru --}}
    <div class="col-lg-6 fade-in-up delay-5">
        <div class="section-card">
            <div class="sc-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background: var(--gradient-warning);">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <span>Pengumuman Terbaru</span>
                </div>
                <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3" style="font-size:.75rem;">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="sc-body">
                @forelse($announcements as $ann)
                    <div class="announce-item">
                        <div class="announce-dot">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div class="announce-content flex-1">
                            <div class="ann-date">
                                {{ $ann->published_at ? $ann->published_at->format('d M Y') : '-' }}
                            </div>
                            <div class="ann-title">{{ $ann->title }}</div>
                            @if($ann->content)
                                <div style="font-size:.78rem; color:var(--student-muted); margin-top:.15rem;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($ann->content), 70) }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-bell-slash"></i>
                        <p>Belum ada pengumuman.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===== Quick Actions ===== --}}
<div class="row g-3 fade-in-up delay-6">
    <div class="col-12">
        <div class="section-card">
            <div class="sc-head">
                <div class="d-flex align-items-center gap-2">
                    <div class="head-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <span>Aksi Cepat</span>
                </div>
            </div>
            <div class="sc-body">
                <div class="row g-3">
                    @if(!$skripsi)
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('student.skripsi.create') }}" class="quick-btn">
                            <div class="qb-icon" style="background:var(--gradient-primary);">
                                <i class="fa-solid fa-file-plus"></i>
                            </div>
                            Ajukan Skripsi
                        </a>
                    </div>
                    @endif
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('student.skripsi.history') }}" class="quick-btn">
                            <div class="qb-icon" style="background:var(--gradient-info);">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            Riwayat Skripsi
                        </a>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('log-books.index') }}" class="quick-btn">
                            <div class="qb-icon" style="background:var(--gradient-success);">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </div>
                            Log Book
                        </a>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('exam-schedules.index') }}" class="quick-btn">
                            <div class="qb-icon" style="background:linear-gradient(135deg,#0891b2,#06b6d4);">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            Jadwal Sidang
                        </a>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('announcements.index') }}" class="quick-btn">
                            <div class="qb-icon" style="background:var(--gradient-warning);">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            Pengumuman
                        </a>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{ route('elective-courses.index') }}" class="quick-btn">
                            <div class="qb-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            MK Pilihan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Animate stat numbers
document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(function (el) {
        const target = parseInt(el.getAttribute('data-count'));
        if (!target) return;
        let current = 0;
        const step = Math.ceil(target / 40);
        const timer = setInterval(function () {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, 20);
    });
});
</script>
@endpush
