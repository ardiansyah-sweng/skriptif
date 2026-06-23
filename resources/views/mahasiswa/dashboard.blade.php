<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistem Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 900px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-primary:hover { background: #0C447C; }
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 20px 24px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 14px; border-bottom: 0.5px solid #e5e7eb; display: flex; align-items: center; gap: 8px; }
        .profile-row { display: flex; align-items: center; gap: 14px; }
        .avatar { width: 48px; height: 48px; border-radius: 50%; background: #E6F1FB; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 500; color: #0C447C; flex-shrink: 0; }
        .profile-name { font-size: 15px; font-weight: 500; }
        .profile-meta { font-size: 13px; color: #6b7280; margin-top: 2px; }
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-success { background: #EAF3DE; color: #27500A; }
        .empty { text-align: center; padding: 32px 16px; color: #9ca3af; font-size: 13px; }
        .empty i { font-size: 28px; display: block; margin-bottom: 8px; opacity: .4; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        tbody tr { border-bottom: 0.5px solid #f0f0f0; }
        tbody td { padding: 10px 0; }
        .grade { text-align: right; color: #185FA5; font-weight: 500; }
        @media (max-width: 600px) { body { padding: 16px; } }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <span>Beranda</span>
                </div>
                <h1>Dashboard</h1>
                <p>Selamat datang, Mahasiswa</p>
            </div>
            <a href="/login" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:transparent;border:0.5px solid #e5e7eb;border-radius:8px;font-size:13px;text-decoration:none;color:#6b7280;">
                <i class="ti ti-logout"></i> Keluar
            </a>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="ti ti-user" style="font-size:15px;color:#185FA5"></i>
                Profil Saya
            </div>
            <div class="profile-row">
                <div class="avatar">MR</div>
                <div>
                    <div class="profile-name">John Doe</div>
                    <div class="profile-meta">2300012345 · Angkatan 2023</div>
                    <div style="margin-top:6px;">
                        <span class="badge badge-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
    <div class="card-title">
        <i class="ti ti-file-text" style="font-size:15px;color:#185FA5"></i>
        Pengajuan Skripsi
    </div>
    <div class="empty">
        <i class="ti ti-file-off"></i>
        <p>Belum ada pengajuan skripsi.</p>
    </div>
    <div style="margin-top:4px;display:flex;gap:8px;">
        <a href="/mahasiswa/skripsi/create" class="btn-primary">
            <i class="ti ti-plus"></i> Ajukan Skripsi
        </a>
        <a href="/mahasiswa/skripsi" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:transparent;border:0.5px solid #e5e7eb;border-radius:8px;font-size:13px;text-decoration:none;color:#6b7280;">
            <i class="ti ti-list"></i> Lihat Riwayat
        </a>
    </div>
</div>

        <div class="card">
            <div class="card-title">
                <i class="ti ti-books" style="font-size:15px;color:#185FA5"></i>
                Riwayat Mata Kuliah Pilihan
            </div>
            <table>
                <tbody>
                    <tr>
                        <td>Pemrograman Web</td>
                        <td class="grade">A</td>
                    </tr>
                    <tr>
                        <td>Machine Learning</td>
                        <td class="grade">B+</td>
                    </tr>
                    <tr>
                        <td>Cloud Computing</td>
                        <td class="grade">A-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>