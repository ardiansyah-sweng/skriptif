<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Thesis Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: #14213d;
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 1030;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar .brand .logo {
            width: 36px;
            height: 36px;
            background: #185FA5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar .brand span {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 14px 10px;
        }

        .sidebar-nav .nav-section {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: rgba(255,255,255,.4);
            padding: 14px 10px 6px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            font-size: 13.5px;
            margin-bottom: 2px;
            transition: .15s;
        }

        .sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-nav a:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .sidebar-nav a.active {
            background: #185FA5;
            color: #fff;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: 13px;
        }

        .sidebar-footer a:hover {
            color: #fff;
        }

        .main-wrap {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h5 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
        }

        .content {
            padding: 24px;
            flex: 1;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrap { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <div class="logo"><i class="fa-solid fa-graduation-cap"></i></div>
            <span>Thesis Management<br>System</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            @php $role = Auth::user()->role ?? 'mahasiswa'; @endphp

            @if($role === 'admin' || $role === 'dosen')
            <div class="nav-section">Skripsi</div>
            <a href="{{ route('skripsi.index') }}" class="{{ request()->routeIs('skripsi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i> Data Skripsi
            </a>
            <a href="{{ route('exam-schedules.index') }}" class="{{ request()->routeIs('exam-schedules.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Jadwal Sidang
            </a>
            @endif

            @if($role === 'admin')
            <div class="nav-section">Akademik</div>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i> Mahasiswa
            </a>
            <a href="{{ route('lecturers.index') }}" class="{{ request()->routeIs('lecturers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Dosen
            </a>
            <a href="{{ route('elective-courses.index') }}" class="{{ request()->routeIs('elective-courses.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i> Mata Kuliah Pilihan
            </a>
            @endif

            @if($role === 'admin' || $role === 'dosen')
            <div class="nav-section">Bimbingan</div>
            <a href="{{ route('log-books.index') }}" class="{{ request()->routeIs('log-books.*') ? 'active' : '' }}">
                <i class="fa-solid fa-notebook"></i> Log Book
            </a>
            @endif

            @if($role === 'mahasiswa')
            <div class="nav-section">Skripsi</div>
            <a href="{{ route('student.skripsi.create') }}" class="{{ request()->routeIs('student.skripsi.create') ? 'active' : '' }}">
                <i class="fa-solid fa-file-plus"></i> Ajukan Skripsi
            </a>
            <a href="{{ route('student.skripsi.history') }}" class="{{ request()->routeIs('student.skripsi.history') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Skripsi
            </a>
            @endif

            <div class="nav-section">Informasi</div>
            <a href="{{ route('announcements.index') }}" class="{{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Pengumuman
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="small px-3 pb-2" style="color:rgba(255,255,255,0.4);font-size:11px;">
                {{ Auth::user()->name }} ({{ ucfirst($role) }})
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:inherit;width:100%;text-align:left;padding:8px 18px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrap">
        <div class="topbar">
            <h5>@yield('title', 'Dashboard')</h5>

            <div class="d-flex align-items-center gap-3">
                <div class="text-muted small">
                    <i class="fa-regular fa-clock"></i> {{ now()->format('d M Y, H:i') }}
                </div>

                @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                <div class="dropdown">
                    <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:10px;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0" style="width: 340px; max-height: 400px; overflow-y:auto;">
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                            <span class="fw-semibold small">Notifikasi</span>
                            @if($unreadCount > 0)
                            <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                                @csrf
                                <button class="btn btn-link btn-sm p-0 text-decoration-none" type="submit">Tandai semua dibaca</button>
                            </form>
                            @endif
                        </div>

                        @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 border-bottom {{ $notification->read_at ? '' : 'bg-light' }}" style="white-space:normal; text-align:left;">
                                    <div class="fw-semibold small">{{ $notification->data['title'] ?? 'Notifikasi' }}</div>
                                    <div class="text-muted small">{{ $notification->data['message'] ?? '' }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ $notification->created_at->diffForHumans() }}</div>
                                </button>
                            </form>
                        @empty
                            <div class="text-muted small text-center py-4">Belum ada notifikasi</div>
                        @endforelse

                        <a href="{{ route('notifications.index') }}" class="d-block text-center py-2 small text-decoration-none">Lihat semua notifikasi</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>