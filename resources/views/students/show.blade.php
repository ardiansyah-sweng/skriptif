<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            padding: 32px 20px 40px;
            color: #1f2937;
        }
        .wrap { max-width: 860px; margin: 0 auto; }
        .hero { display: flex; justify-content: space-between; gap: 16px; align-items: center; margin-bottom: 18px; }
        .crumb { display: inline-flex; gap: 6px; align-items: center; font-size: 12px; color: #64748b; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 30px; letter-spacing: -0.03em; }
        .back {
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none; background: #fff;
            color: #334155; border: 1px solid #dbe3ee; border-radius: 12px; padding: 11px 14px; font-weight: 600;
        }
        .back:hover { background: #f8fafc; }
        .card {
            background: rgba(255,255,255,.92); border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08); overflow: hidden;
        }
        .top {
            padding: 24px; display: flex; gap: 16px; align-items: center; border-bottom: 1px solid #eef2f7;
            background: linear-gradient(135deg, rgba(24, 95, 165, 0.08), rgba(250, 204, 21, 0.08));
        }
        .avatar {
            width: 72px; height: 72px; border-radius: 22px; display: grid; place-items: center;
            color: #fff; font-size: 30px; font-weight: 800; background: linear-gradient(135deg, #185FA5, #5ea1e3);
        }
        .name { font-size: 24px; font-weight: 800; margin: 0; }
        .meta { color: #64748b; margin-top: 4px; }
        .body { padding: 24px; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .item {
            background: #fff; border: 1px solid #e6edf6; border-radius: 16px; padding: 16px;
        }
        .label { color: #64748b; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .08em; }
        .value { font-size: 15px; font-weight: 700; word-break: break-word; }
        .badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 999px;
            font-size: 12px; font-weight: 800; margin-top: 4px;
        }
        .badge.active { color: #166534; background: #dcfce7; }
        .badge.inactive { color: #9a3412; background: #ffedd5; }
        @media (max-width: 720px) {
            body { padding: 18px 14px 28px; }
            .hero { flex-direction: column; align-items: stretch; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <div>
                <div class="crumb">
                    <i class="ti ti-home"></i>
                    <span>Beranda</span>
                    <i class="ti ti-chevron-right"></i>
                    <a href="{{ route('students.index') }}" style="color:#64748b;text-decoration:none">Students</a>
                    <i class="ti ti-chevron-right"></i>
                    <span>Detail</span>
                </div>
                <h1>Detail Student</h1>
            </div>
            <a href="{{ route('students.index') }}" class="back"><i class="ti ti-arrow-left"></i> Kembali</a>
        </div>

        <div class="card">
            <div class="top">
                <div class="avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                <div>
                    <h2 class="name">{{ $student->name }}</h2>
                    <div class="meta">{{ $student->student_id }} • {{ $student->email }}</div>
                    <span class="badge {{ $student->status === 'active' ? 'active' : 'inactive' }}">
                        {{ $student->status }}
                    </span>
                </div>
            </div>

            <div class="body">
                <div class="grid">
                    <div class="item">
                        <div class="label">Student ID</div>
                        <div class="value">{{ $student->student_id }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Angkatan</div>
                        <div class="value">{{ $student->year_entrance }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Nama</div>
                        <div class="value">{{ $student->name }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Email</div>
                        <div class="value">{{ $student->email }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Status</div>
                        <div class="value">{{ ucfirst($student->status) }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Created At</div>
                        <div class="value">{{ optional($student->created_at)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($student->skripsi)
        <div class="card" style="margin-top: 18px;">
            <div class="top" style="background: linear-gradient(135deg, rgba(250, 204, 21, 0.08), rgba(24, 95, 165, 0.08));">
                <div class="avatar" style="background: linear-gradient(135deg, #d97706, #f59e0b);">
                    <i class="ti ti-book"></i>
                </div>
                <div>
                    <h2 class="name" style="font-size: 20px;">Pengajuan Skripsi</h2>
                    <div class="meta">Status:
                        @if($student->skripsi->status == 'pending')
                            <span class="badge" style="background: #fef3c7; color: #92400e;">Menunggu Review</span>
                        @elseif($student->skripsi->status == 'approved')
                            <span class="badge" style="background: #d1fae5; color: #065f46;">Disetujui</span>
                        @else
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="grid">
                    <div class="item">
                        <div class="label">Judul</div>
                        <div class="value" style="font-weight: 600;">{{ $student->skripsi->title }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Pembimbing</div>
                        <div class="value">{{ $student->skripsi->supervisor->name ?? 'Belum ditentukan' }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Tanggal Pengajuan</div>
                        <div class="value">{{ $student->skripsi->submission_date ? $student->skripsi->submission_date->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="item">
                        <div class="label">Tanggal Disetujui</div>
                        <div class="value">{{ $student->skripsi->approval_date ? $student->skripsi->approval_date->format('d M Y') : '-' }}</div>
                    </div>
                    @if($student->skripsi->rejection_note)
                    <div class="item" style="grid-column: 1 / -1;">
                        <div class="label">Catatan Penolakan</div>
                        <div class="value" style="color: #dc2626;">{{ $student->skripsi->rejection_note }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>