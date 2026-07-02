<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan Skripsi — Sistem Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 1000px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; }
        th { background-color: #f8fafc; font-weight: 500; color: #374151; border-bottom: 1px solid #e5e7eb; }
        tr { border-bottom: 0.5px solid #e5e7eb; }
        tr:hover { background-color: #f8fafc; }
        
        .status-pending { background-color: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-approved { background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-primary:hover { background: #0C447C; }
        
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
                    <span>Riwayat Skripsi</span>
                </div>
                <h1>Riwayat Pengajuan Skripsi</h1>
                <p>Daftar semua usulan proposal skripsi yang telah Anda ajukan</p>
            </div>
            <a href="{{ route('student.skripsi.create') }}" class="btn-primary">
                <i class="ti ti-plus"></i> Ajukan Proposal Baru
            </a>
        </div>

        <div class="card">
            <div class="card-title">Daftar Pengajuan</div>

            @if(session('success'))
                <div style="background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px;">
                    {{ session('success') == 'Pengajuan berhasil!' ? 'Pengajuan berhasil!' : session('success') }}
                </div>
            @endif

            @if($skripsis->isEmpty())
                <p style="text-align:center; padding:40px; color:#6b7280;">Tidak ada data pengajuan skripsi.</p>
            @else
                 <table>
                    <thead>
                        <tr>
                            <th>Judul Skripsi</th>
                            <th>Dosen Pembimbing</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th style="text-align: center; width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skripsis as $skripsi)
                        <tr>
                            <td>{{ $skripsi->title }}</td>
                            <td>
                                @if($skripsi->supervisor)
                                    {{ $skripsi->supervisor->name }}
                                @else
                                    <span style="color:#9ca3af;">Belum ditentukan</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($skripsi->status) {
                                        'pending' => 'status-pending',
                                        'approved' => 'status-approved',
                                        'rejected' => 'status-rejected',
                                        default => ''
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ $skripsi->status == 'pending' ? 'Pending' : ($skripsi->status == 'approved' ? 'Approved' : 'Rejected') }}</span>
                            </td>
                            <td>{{ $skripsi->submission_date ? $skripsi->submission_date->format('d M Y') : '-' }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('student.skripsi.show', $skripsi->id) }}" class="btn-primary" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; gap: 4px;" id="btn-show-{{ $skripsi->id }}">
                                    <i class="ti ti-eye" style="font-size: 11px"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>