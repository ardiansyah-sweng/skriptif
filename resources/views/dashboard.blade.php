<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Skriptif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background:
                radial-gradient(circle at top left, rgba(24, 95, 165, 0.14), transparent 28%),
                radial-gradient(circle at top right, rgba(250, 204, 21, 0.15), transparent 22%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            padding: 0;
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
        .navbar-menu {
            display: flex;
            gap: 24px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .navbar-menu a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .navbar-menu a:hover {
            color: #185FA5;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #185FA5, #5ea1e3);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            cursor: pointer;
        }
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 20px;
        }
        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        .welcome-text h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: -0.03em;
            color: #1f2937;
        }
        .welcome-text p {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 15px;
        }
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
        }
        .stat-icon.blue { background: rgba(24, 95, 165, 0.1); color: #185FA5; }
        .stat-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .stat-icon.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
        .stat-icon.purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
        .stat-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 6px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 32px 72px rgba(15, 23, 42, 0.12);
            border-color: rgba(24, 95, 165, 0.3);
        }
        .feature-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .feature-icon.blue { background: rgba(24, 95, 165, 0.1); color: #185FA5; }
        .feature-icon.green { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .feature-icon.orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }
        .feature-icon.purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
        .feature-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        .feature-desc {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .navbar-menu {
                display: none;
            }
        }
        @media (max-width: 640px) {
            .navbar {
                padding: 12px 16px;
            }
            .navbar-brand {
                font-size: 16px;
            }
            .navbar-logo {
                width: 32px;
                height: 32px;
            }
            .container {
                padding: 20px 16px;
            }
            .welcome-section {
                flex-direction: column;
                align-items: flex-start;
            }
            .welcome-text h1 {
                font-size: 24px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">
            <div class="navbar-logo">S</div>
            Skriptif
        </a>
        <ul class="navbar-menu">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/students">Students</a></li>
            <li><a href="/lecturers">Lecturers</a></li>
            <li><a href="/skripsi">Skripsi</a></li>
            <li><a href="/elective-courses">Elective Courses</a></li>
        </ul>
        <div class="user-menu">
            <div class="user-avatar">U</div>
            <a href="/login" class="logout-btn">
                <i class="ti ti-logout"></i> Logout
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Selamat datang kembali 👋</h1>
                <p>Kelola semua data akademik Anda dari sini</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="ti ti-users"></i>
                </div>
                <div class="stat-label">Total Students</div>
                <div class="stat-value">248</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="ti ti-user-check"></i>
                </div>
                <div class="stat-label">Active Students</div>
                <div class="stat-value">196</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="ti ti-school"></i>
                </div>
                <div class="stat-label">Total Lecturers</div>
                <div class="stat-value">32</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="ti ti-book"></i>
                </div>
                <div class="stat-label">Ongoing Skripsi</div>
                <div class="stat-value">84</div>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <h2 style="margin: 0 0 20px 0; font-size: 20px; color: #1f2937;">Menu Utama</h2>
        </div>

        <div class="features-grid">
            <a href="/students" class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon blue">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <h3 class="feature-title">Data Students</h3>
                        <p class="feature-desc">Kelola data mahasiswa</p>
                    </div>
                </div>
            </a>

            <a href="/lecturers" class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon green">
                        <i class="ti ti-school"></i>
                    </div>
                    <div>
                        <h3 class="feature-title">Data Lecturers</h3>
                        <p class="feature-desc">Kelola data dosen</p>
                    </div>
                </div>
            </a>

            <a href="/skripsi" class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon orange">
                        <i class="ti ti-book"></i>
                    </div>
                    <div>
                        <h3 class="feature-title">Skripsi</h3>
                        <p class="feature-desc">Kelola data skripsi</p>
                    </div>
                </div>
            </a>

            <a href="/elective-courses" class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon purple">
                        <i class="ti ti-layout-list"></i>
                    </div>
                    <div>
                        <h3 class="feature-title">Elective Courses</h3>
                        <p class="feature-desc">Kelola mata kuliah pilihan</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
