<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Skripsi Management</title>
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
        .stat-card {
            background: #fff; border-radius: 12px; padding: 20px 24px;
            border: 1px solid #e2e8f0; transition: all 0.3s; height: 100%;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 12px;
        }
        .stat-value { font-size: 28px; font-weight: 800; line-height: 1.2; }
        .stat-label { font-size: 13px; color: #64748b; font-weight: 500; margin-top: 2px; }
        .card-custom {
            background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;
        }
        .card-custom .card-header {
            background: #fff; padding: 16px 20px; border-bottom: 1px solid #e2e8f0;
            font-weight: 600; font-size: 15px;
        }
        .table-custom th {
            font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
            color: #64748b; background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px 16px;
        }
        .table-custom td { font-size: 13px; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .table-custom tr:last-child td { border-bottom: none; }
        .badge-status { font-size: 12px; font-weight: 500; padding: 4px 10px; border-radius: 6px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; }
        .menu-item {
            display: flex; align-items: center; gap: 12px; padding: 14px 16px;
            background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
            text-decoration: none; color: #334155; font-size: 14px; font-weight: 500;
            transition: all 0.2s;
        }
        .menu-item:hover { background: #f8fafc; border-color: #94a3b8; color: #1e293b; transform: translateY(-1px); }
        .menu-item i { width: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h3>Skriptif</h3>
        <small>Skripsi Management System</small>
    </div>
    <div class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('students.index') }}"><i class="fa-solid fa-user-graduate"></i> Mahasiswa</a>
        <a href="{{ route('lecturers.index') }}"><i class="fa-solid fa-chalkboard-user"></i> Dosen</a>
        <a href="{{ route('skripsi.index') }}"><i class="fa-solid fa-book"></i> Skripsi</a>
        <a href="{{ route('log-books.index') }}"><i class="fa-solid fa-clipboard-list"></i> Log Book</a>
        <a href="{{ route('exam-schedules.index') }}"><i class="fa-solid fa-calendar-check"></i> Jadwal Sidang</a>
        <a href="{{ route('elective-courses.index') }}"><i class="fa-solid fa-layer-group"></i> MK Pilihan</a>

        <div class="nav-label">Mahasiswa</div>
        <a href="{{ route('student.skripsi.create') }}"><i class="fa-solid fa-file-circle-plus"></i> Ajukan Skripsi</a>
        <a href="{{ route('student.skripsi.history') }}"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</a>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <h4>Dashboard</h4>
        </div>
        <span class="badge-date"><i class="fa-regular fa-calendar me-1"></i> {{ now()->format('d F Y') }}</span>
    </div>

    <div class="content">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #dbeafe; color: #2563eb;"><i class="fa-solid fa-user-graduate"></i></div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Mahasiswa</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="fa-solid fa-chalkboard-user"></i></div>
                    <div class="stat-value">{{ $totalLecturers }}</div>
                    <div class="stat-label">Total Dosen</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef3c7; color: #d97706;"><i class="fa-solid fa-book"></i></div>
                    <div class="stat-value">{{ $totalSkripsi }}</div>
                    <div class="stat-label">Total Skripsi</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fce7f3; color: #db2777;"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-value">{{ $totalExamSchedules }}</div>
                    <div class="stat-label">Jadwal Sidang</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-7">
                <div class="card-custom">
                    <div class="card-header">
                        <i class="fa-regular fa-file-lines me-2 text-primary"></i> 5 Skripsi Terbaru
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Pembimbing</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSkripsi as $s)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ $s->student->name ?? '-' }}</div>
                                        <small class="text-muted">NIM. {{ $s->student->student_id ?? '-' }}</small>
                                    </td>
                                    <td>{{ Str::limit($s->title, 50) }}</td>
                                    <td>{{ $s->supervisor->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($s->status == 'pending')
                                            <span class="badge-status bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Menunggu</span>
                                        @elseif($s->status == 'approved')
                                            <span class="badge-status bg-success bg-opacity-10 text-success border border-success border-opacity-25">Disetujui</span>
                                        @else
                                            <span class="badge-status bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data skripsi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card-custom">
                    <div class="card-header">
                        <i class="fa-solid fa-link me-2 text-primary"></i> Menu Cepat
                    </div>
                    <div class="card-body p-3">
                        <div class="menu-grid">
                            <a href="{{ route('students.index') }}" class="menu-item"><i class="fa-solid fa-user-graduate text-primary"></i> Mahasiswa</a>
                            <a href="{{ route('lecturers.index') }}" class="menu-item"><i class="fa-solid fa-chalkboard-user text-success"></i> Dosen</a>
                            <a href="{{ route('skripsi.index') }}" class="menu-item"><i class="fa-solid fa-book text-warning"></i> Skripsi</a>
                            <a href="{{ route('log-books.index') }}" class="menu-item"><i class="fa-solid fa-clipboard-list text-info"></i> Log Book</a>
                            <a href="{{ route('exam-schedules.index') }}" class="menu-item"><i class="fa-solid fa-calendar-check text-danger"></i> Jadwal</a>
                            <a href="{{ route('elective-courses.index') }}" class="menu-item"><i class="fa-solid fa-layer-group text-secondary"></i> MK Pilihan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
