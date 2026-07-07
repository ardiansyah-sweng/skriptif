<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); padding: 32px; }
        .detail-label { font-size: 13px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .detail-value { font-size: 15px; color: #0f172a; font-weight: 500; }
        .detail-row { padding: 16px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .btn-back-custom { background-color: transparent; color: #64748b; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: 1px solid #e2e8f0; text-decoration: none; }
        .btn-back-custom:hover { background-color: #f1f5f9; color: #334155; }
        .btn-edit-action { background-color: #3b82f6; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: none; text-decoration: none; }
        .btn-edit-action:hover { background-color: #2563eb; color: white; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 700px;">

        <div class="crumb mb-3">
            <i class="fa-solid fa-house"></i>
            <a href="{{ route('dashboard') }}" style="color:#64748b;text-decoration:none">Dashboard</a>
            <i class="fa-solid fa-chevron-right" style="font-size:8px"></i>
            <a href="{{ route('lecturers.index') }}" style="color:#64748b;text-decoration:none">Data Dosen</a>
            <i class="fa-solid fa-chevron-right" style="font-size:8px"></i>
            <span class="fw-semibold" style="color:#0f172a;">Detail</span>
        </div>

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Detail Dosen</h1>
                <p class="sub-title">Informasi lengkap data dosen.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn-back-custom">
                    <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('lecturers.index') }}" class="btn-back-custom">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="content-card">
            <div class="detail-row">
                <div class="detail-label">NIDN / ID Dosen</div>
                <div class="detail-value">{{ $lecturer->lecturer_id }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value">{{ $lecturer->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value"><i class="fa-solid fa-envelope me-1 text-muted"></i> {{ $lecturer->email }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Keahlian</div>
                <div class="detail-value">{{ $lecturer->expertise ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Maks. Mahasiswa per Angkatan</div>
                <div class="detail-value">{{ $lecturer->max_supervisors ?? 3 }} mahasiswa</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Terdaftar Sejak</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($lecturer->created_at)->translatedFormat('d F Y, H:i') }}</div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('lecturers.index') }}" class="btn-back-custom">Tutup</a>
                <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="btn-edit-action">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Dosen
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
