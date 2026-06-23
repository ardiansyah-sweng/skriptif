<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skripsi — Sistem Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 900px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; display: flex; align-items: center; gap: 8px; }
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-warning { background: #FAEEDA; color: #633806; }
        .badge-danger { background: #FCEBEB; color: #791F1F; }
        .alert { display: flex; align-items: flex-start; gap: 10px; padding: 14px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; border: 0.5px solid; }
        .alert-danger { background: #FCEBEB; border-color: #F09595; color: #791F1F; }
        .info-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; padding: 10px 0; border-bottom: 0.5px solid #f0f0f0; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; }
        .skripsi-title { font-size: 16px; font-weight: 500; margin-bottom: 6px; line-height: 1.4; }
        .skripsi-desc { font-size: 13px; color: #6b7280; line-height: 1.6; }
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; text-decoration: none; }
        .btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: transparent; color: #1a1a2e; border: 0.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        tbody tr { border-bottom: 0.5px solid #f0f0f0; }
        tbody td { padding: 10px 0; }
        .grade { font-weight: 500; color: #185FA5; text-align: right; }
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
                    <a href="/mahasiswa/dashboard" style="color:#9ca3af;text-decoration:none;">Dashboard</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Detail Skripsi</span>
                </div>
                <h1>Detail Skripsi</h1>
                <p>Informasi lengkap pengajuan skripsi kamu</p>
            </div>
            <a href="/mahasiswa/skripsi/2/edit" class="btn-primary">
                <i class="ti ti-edit"></i> Edit
            </a>
        </div>

        <div class="alert alert-danger">
            <i class="ti ti-alert-circle"></i>
            <div>
                <strong>Pengajuan ditolak</strong><br>
                Judul skripsi kurang spesifik. Harap perjelas ruang lingkup dan objek penelitian.
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="ti ti-file-text" style="font-size:15px;color:#185FA5"></i>
                Informasi Skripsi
            </div>

            <div style="margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                    <div class="skripsi-title">Implementasi Machine Learning untuk Deteksi Spam</div>
                    <span class="badge badge-danger" style="margin-left:12px;flex-shrink:0;">Ditolak</span>
                </div>
                <p class="skripsi-desc">Penerapan algoritma Naive Bayes pada klasifikasi email untuk mendeteksi pesan spam secara otomatis dengan tingkat akurasi tinggi.</p>
            </div>

            <div class="info-row">
                <span class="info-label">Tanggal diajukan</span>
                <span>22 Mar 2026</span>
            </div>
            <div class="info-row">
                <span class="info-label">Usulan pembimbing</span>
                <span>Dr. Ardiansyah, S.T., M.Cs.</span>
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
                        <td>Kecerdasan Buatan</td>
                        <td class="grade">A</td>
                    </tr>
                    <tr>
                        <td>Basis Data Lanjut</td>
                        <td class="grade">B</td>
                    </tr>
                    <tr>
                        <td>Rekayasa Perangkat Lunak</td>
                        <td class="grade">A</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="/mahasiswa/skripsi" class="btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>
</body>
</html>