<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Skripsi — Sistem Skripsi</title>
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
        .table-wrap { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #f9fafb; }
        thead th { padding: 10px 16px; font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; border-bottom: 0.5px solid #e5e7eb; text-align: left; }
        tbody tr { border-bottom: 0.5px solid #f0f0f0; transition: background .1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f9fafb; }
        tbody td { padding: 13px 16px; vertical-align: middle; }
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-warning { background: #FAEEDA; color: #633806; }
        .badge-success { background: #EAF3DE; color: #27500A; }
        .badge-danger  { background: #FCEBEB; color: #791F1F; }
        .title-cell { font-weight: 500; color: #1a1a2e; margin-bottom: 2px; }
        .desc-cell { font-size: 12px; color: #6b7280; }
        .date-col { font-size: 12px; color: #6b7280; }
        .btn-detail { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; background: transparent; border: 0.5px solid #e5e7eb; border-radius: 6px; font-size: 12px; color: #185FA5; text-decoration: none; }
        .btn-detail:hover { background: #E6F1FB; border-color: #85B7EB; }
        .empty { text-align: center; padding: 56px 16px; color: #9ca3af; }
        .empty i { font-size: 36px; display: block; margin-bottom: 10px; opacity: .4; }
        .empty p { font-size: 14px; }
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
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <a href="#" style="color:#9ca3af;text-decoration:none;">Dashboard</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Riwayat Skripsi</span>
                </div>
                <h1>Riwayat Pengajuan Skripsi</h1>
                <p>Semua pengajuan skripsi yang pernah kamu buat</p>
            </div>
            <a href="/mahasiswa/skripsi/create"  class="btn-primary">
                <i class="ti ti-plus"></i> Ajukan Baru
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">No</th>
                        <th>Judul</th>
                        <th style="width:140px">Tanggal Diajukan</th>
                        <th style="width:130px">Status</th>
                        <th style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color:#9ca3af;font-size:12px;">1</td>
                        <td>
                            <div class="title-cell">Implementasi Machine Learning untuk Deteksi Spam</div>
                            <div class="desc-cell">Penerapan algoritma Naive Bayes pada klasifikasi email...</div>
                        </td>
                        <td class="date-col">22 Mar 2026</td>
                        <td><span class="badge badge-danger">Ditolak</span></td>
                        <td><a href="/mahasiswa/skripsi/1" class="btn-detail"><i class="ti ti-eye"></i> Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>