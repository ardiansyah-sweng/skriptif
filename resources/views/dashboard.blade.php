<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Skriptif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background:
                radial-gradient(circle at top left, rgba(24, 95, 165, 0.14), transparent 28%),
                radial-gradient(circle at top right, rgba(250, 204, 21, 0.15), transparent 22%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            background-attachment: fixed;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
        }
        .navbar-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #185FA5, #5ea1e3);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid #dbe3ee;
            border-radius: 10px;
            color: #334155;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }
        .logout-btn:hover {
            background: #eef4fa;
            border-color: #cbd5e1;
        }
        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 20px 32px;
        }
        .hero {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-end;
            margin-bottom: 22px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        .crumb {
            display: inline-flex;
            gap: 6px;
            align-items: center;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 10px;
        }
        h1 { margin: 0; font-size: 30px; letter-spacing: -0.03em; }
        .sub { margin: 8px 0 0; color: #64748b; font-size: 14px; max-width: 620px; }
        .stats {
            display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px;
            margin-bottom: 18px;
        }
        .stat {
            background: rgba(255,255,255,.88); backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.18); border-radius: 18px; padding: 18px;
        }
        .stat .label { color: #64748b; font-size: 12px; margin-bottom: 8px; }
        .stat .value { font-size: 28px; font-weight: 700; line-height: 1; }
        .stat-icon { font-size: 20px; margin-bottom: 10px; }
        .stat-icon.blue { color: #185FA5; }
        .stat-icon.green { color: #22c55e; }
        .stat-icon.orange { color: #f97316; }
        .stat-icon.purple { color: #a855f7; }
        .menu-section {
            margin-bottom: 0;
        }
        .menu-section h2 {
            margin: 0 0 16px; font-size: 18px; color: #1f2937; font-weight: 600;
        }
        .menu-grid {
            display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px;
        }
        .menu-card {
            background: rgba(255,255,255,.88); backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.18); border-radius: 18px;
            padding: 20px; text-decoration: none; color: #1f2937;
            transition: all 0.3s;
        }
        .menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 72px rgba(15, 23, 42, 0.12);
            border-color: rgba(24, 95, 165, 0.3);
        }
        .menu-header {
            display: flex; align-items: center; gap: 12px; margin-bottom: 12px;
        }
        .menu-icon {
            width: 40px; height: 40px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; font-size: 20px;
        }
        .menu-icon.blue { background: rgba(24, 95, 165, 0.1); color: #185FA5; }
        .menu-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .menu-icon.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
        .menu-icon.purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
        .menu-title { font-size: 15px; font-weight: 700; margin: 0; }
        .menu-desc { font-size: 12px; color: #64748b; margin: 4px 0 0; }
        @media (max-width: 860px) {
            .navbar { padding: 12px 16px; }
            .container { padding: 18px 14px 28px; }
            .hero { flex-direction: column; align-items: stretch; }
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .menu-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">
            <div class="navbar-logo">S</div>
            Skriptif
        </a>
        <a href="#" class="logout-btn">
            <i class="ti ti-logout"></i> Logout
        </a>
    </nav>

    <div class="container">
        <div class="hero">
            <div>
                <div class="crumb">
                    <i class="ti ti-home"></i>
                    <span>Dashboard</span>
                </div>
                <h1>Selamat datang 👋</h1>
                <p class="sub">Kelola semua data akademik dari satu tempat</p>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <div class="stat-icon blue"><i class="ti ti-users"></i></div>
                <div class="label">Total Students</div>
                <div class="value">248</div>
            </div>
            <div class="stat">
                <div class="stat-icon green"><i class="ti ti-user-check"></i></div>
                <div class="label">Active Students</div>
                <div class="value">196</div>
            </div>
            <div class="stat">
                <div class="stat-icon orange"><i class="ti ti-school"></i></div>
                <div class="label">Total Lecturers</div>
                <div class="value">32</div>
            </div>
            <div class="stat">
                <div class="stat-icon purple"><i class="ti ti-book"></i></div>
                <div class="label">Ongoing Skripsi</div>
                <div class="value">84</div>
            </div>
        </div>

        <div class="menu-section">
            <h2>Menu Utama</h2>
            <div class="menu-grid">
                <a href="/students" class="menu-card">
                    <div class="menu-header">
                        <div class="menu-icon blue"><i class="ti ti-users"></i></div>
                        <div>
                            <h3 class="menu-title">Data Students</h3>
                            <p class="menu-desc">Kelola data mahasiswa</p>
                        </div>
                    </div>
                </a>

                <a href="/lecturers" class="menu-card">
                    <div class="menu-header">
                        <div class="menu-icon green"><i class="ti ti-school"></i></div>
                        <div>
                            <h3 class="menu-title">Data Lecturers</h3>
                            <p class="menu-desc">Kelola data dosen</p>
                        </div>
                    </div>
                </a>

                <a href="/skripsi" class="menu-card">
                    <div class="menu-header">
                        <div class="menu-icon orange"><i class="ti ti-book"></i></div>
                        <div>
                            <h3 class="menu-title">Skripsi</h3>
                            <p class="menu-desc">Kelola data skripsi</p>
                        </div>
                    </div>
                </a>

                <a href="/elective-courses" class="menu-card">
                    <div class="menu-header">
                        <div class="menu-icon purple"><i class="ti ti-layout-list"></i></div>
                        <div>
                            <h3 class="menu-title">Elective Courses</h3>
                            <p class="menu-desc">Kelola mata kuliah pilihan</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
