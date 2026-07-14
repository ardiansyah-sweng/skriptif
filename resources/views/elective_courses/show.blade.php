<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Kuliah Pilihan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; color: #111827; padding: 32px 20px; }
        .container { max-width: 780px; margin: 0 auto; }
        .card { background: #fff; border-radius: 22px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); overflow: hidden; }
        .card-header { padding: 30px 32px; border-bottom: 1px solid #e5e7eb; }
        .card-header h1 { margin: 0; font-size: 24px; letter-spacing: -0.03em; }
        .card-header p { margin: 10px 0 0; color: #6b7280; font-size: 14px; }
        .card-body { padding: 30px 32px; }
        .field { display: grid; gap: 10px; margin-bottom: 24px; }
        .field label { color: #6b7280; font-size: 12px; letter-spacing: .08em; text-transform: uppercase; }
        .field .value { font-size: 16px; color: #111827; line-height: 1.75; }
        .meta-card { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-top: 24px; }
        .meta { border: 1px solid #e5e7eb; border-radius: 18px; padding: 18px; background: #f8fafc; }
        .meta strong { display: block; color: #111827; margin-bottom: 6px; }
        .meta span { color: #6b7280; font-size: 13px; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 10px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 18px; border-radius: 12px; text-decoration: none; font-weight: 600; }
        .btn-back { background: #e2e8f0; color: #1f2937; }
        .btn-edit { background: #185fa5; color: #fff; }
        .btn-icon { display: inline-flex; justify-content: center; width: 36px; height: 36px; border-radius: 12px; background: #e2e8f0; color: #1f2937; }
        .badge { display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: 999px; background: #eff6ff; color: #1d4ed8; font-weight: 700; }
        @media (max-width: 640px) { .meta-card { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="actions">
                    <a href="{{ route('elective-courses.index') }}" class="btn btn-back">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('elective-courses.edit', $course->id) }}" class="btn btn-edit">
                        <i class="ti ti-edit"></i> Edit
                    </a>
                </div>
                <h1>Detail Mata Kuliah Pilihan</h1>
                <p>Informasi lengkap tentang mata kuliah pilihan ini.</p>
            </div>
            <div class="card-body">
                <div class="field">
                    <label>Nama Mata Kuliah</label>
                    <div class="value">{{ $course->courses }}</div>
                </div>

                <div class="field">
                    <label>Tanggal Ditambahkan</label>
                    <div class="value">{{ \Carbon\Carbon::parse($course->timestamp)->translatedFormat('d F Y H:i') }}</div>
                </div>

                <div class="meta-card">
                    <div class="meta">
                        <strong>ID Course</strong>
                        <span>{{ $course->id }}</span>
                    </div>
                    <div class="meta">
                        <strong>Timestamp</strong>
                        <span>{{ $course->timestamp }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
