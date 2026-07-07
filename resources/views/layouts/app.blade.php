<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Skriptif</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; color: #1e293b; }
        .sidebar {
            width: 260px; height: 100vh; position: fixed; top: 0; left: 0;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #fff; padding: 0; z-index: 1000;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand h3 { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; margin: 0; }
        .sidebar-brand small { font-size: 12px; color: #94a3b8; }
        .sidebar-nav { padding: 12px 0; flex: 1; overflow-y: auto; }
        .sidebar-nav .nav-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; padding: 16px 20px 6px; font-weight: 600; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 20px; color: #cbd5e1; text-decoration: none;
            font-size: 14px; font-weight: 500; transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.06); color: #fff; border-left-color: #3b82f6; }
        .sidebar-nav a i { width: 20px; text-align: center; font-size: 16px; }
        .sidebar-nav a.active { background: rgba(59,130,246,0.12); color: #60a5fa; border-left-color: #3b82f6; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar {
            background: #fff; padding: 16px 30px; display: flex; align-items: center;
            justify-content: space-between; border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 999;
        }
        .topbar h4 { font-size: 18px; font-weight: 700; margin: 0; }
        .topbar .badge-date { font-size: 12px; color: #64748b; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; }
        .content { padding: 24px 30px; }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h3>Skriptif</h3>
        <small>Skripsi Management System</small>
    </div>
    <div class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-graduate"></i> Mahasiswa
        </a>
        <a href="{{ route('lecturers.index') }}" class="{{ request()->routeIs('lecturers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-chalkboard-user"></i> Dosen
        </a>
        <a href="{{ route('skripsi.index') }}" class="{{ request()->routeIs('skripsi.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book"></i> Skripsi
        </a>
        <a href="{{ route('log-books.index') }}" class="{{ request()->routeIs('log-books.*') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i> Log Book
        </a>
        <a href="{{ route('exam-schedules.index') }}" class="{{ request()->routeIs('exam-schedules.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i> Jadwal Sidang
        </a>
        <a href="{{ route('elective-courses.index') }}" class="{{ request()->routeIs('elective-courses.*') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> MK Pilihan
        </a>

        <div class="nav-label">Mahasiswa</div>
        <a href="{{ route('student.skripsi.create') }}" class="{{ request()->routeIs('student.skripsi.create') ? 'active' : '' }}">
            <i class="fa-solid fa-file-circle-plus"></i> Ajukan Skripsi
        </a>
        <a href="{{ route('student.skripsi.history') }}" class="{{ request()->routeIs('student.skripsi.history') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
        </a>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <h4>@yield('title', 'Dashboard')</h4>
        </div>
        <span class="badge-date"><i class="fa-regular fa-calendar me-1"></i> {{ now()->format('d F Y') }}</span>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
