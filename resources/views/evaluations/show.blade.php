<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Evaluasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 640px; margin: 0 auto; }

        .crumb {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-head { margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; }
        .page-head h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }

        .grade-badge-lg {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 700;
        }
        .grade-A { background: #E6F7EE; color: #16794A; }
        .grade-B { background: #E6F1FB; color: #0C447C; }
        .grade-C { background: #FFF6E0; color: #A66A00; }
        .grade-D { background: #FCEBEB; color: #A32D2D; }
        .grade-E { background: #F3E8FD; color: #6B21A8; }

        .card {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 0.5px solid #f0f0f0;
            font-size: 13px;
        }
        .row:last-child { border-bottom: none; }
        .row .label { color: #9ca3af; }
        .row .value { color: #1a1a2e; font-weight: 500; text-align: right; max-width: 60%; }

        .notes-box {
            margin-top: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 13px;
            color: #374151;
            line-height: 1.5;
        }

        .actions { display: flex; gap: 8px; margin-top: 20px; }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #185FA5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
        }
        .btn-primary:hover { background: #0C447C; }

        .btn-cancel {
            padding: 9px 18px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
        }
        .btn-cancel:hover { background: #f4f6f9; }
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
                    <a href="{{ route('evaluations.index') }}" style="color:#9ca3af;text-decoration:none">Evaluasi Skripsi</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Detail</span>
                </div>
                <h1>Detail Evaluasi</h1>
                <p>{{ $evaluation->skripsi->student->name ?? '-' }}</p>
            </div>
            <div class="grade-badge-lg grade-{{ $evaluation->grade }}">{{ $evaluation->grade }}</div>
        </div>

        <div class="card">
            <div class="row">
                <span class="label">Judul Skripsi</span>
                <span class="value">{{ $evaluation->skripsi->title ?? '-' }}</span>
            </div>
            <div class="row">
                <span class="label">Dosen Penguji</span>
                <span class="value">{{ $evaluation->lecturer->name ?? '-' }}</span>
            </div>
            <div class="row">
                <span class="label">Nilai</span>
                <span class="value">{{ number_format($evaluation->score, 1) }} ({{ $evaluation->grade }})</span>
            </div>
            <div class="row">
                <span class="label">Tanggal Evaluasi</span>
                <span class="value">{{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d M Y') }}</span>
            </div>

            @if($evaluation->notes)
                <div class="row" style="display:block">
                    <span class="label">Catatan</span>
                    <div class="notes-box">{{ $evaluation->notes }}</div>
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn-primary">
                    <i class="ti ti-edit"></i> Edit
                </a>
                <a href="{{ route('evaluations.index') }}" class="btn-cancel">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>