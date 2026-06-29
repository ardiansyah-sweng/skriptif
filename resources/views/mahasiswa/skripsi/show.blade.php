<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Timeline Pengajuan Skripsi — Sistem Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 1100px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        
        .grid-layout {
            display: grid;
            grid-template-columns: 1.8fr 1.2fr;
            gap: 24px;
        }
        @media (max-width: 900px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
        
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 14px; font-weight: 600; padding-bottom: 12px; margin-bottom: 20px; border-bottom: 0.5px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
        
        .btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fff; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; transition: background 0.15s; }
        .btn-secondary:hover { background: #f9fafb; }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .meta-item .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #9ca3af;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .meta-item .val {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }
        
        .section-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #9ca3af;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            margin-top: 16px;
        }
        .desc-box {
            font-size: 13.5px;
            line-height: 1.6;
            color: #4b5563;
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 8px;
            border: 1px dashed #d1d5db;
            margin-bottom: 20px;
            white-space: pre-line;
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 10px 12px; text-align: left; font-size: 13px; }
        th { background-color: #f9fafb; font-weight: 500; color: #374151; border: 1px solid #e5e7eb; }
        td { border: 1px solid #e5e7eb; }
        
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 24px;
            margin-left: 8px;
            border-left: 2px solid #e5e7eb;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        .timeline-marker {
            position: absolute;
            left: -33px;
            top: 2px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: white;
            box-shadow: 0 0 0 3px #fff;
        }
        .marker-pending { background-color: #d97706; }
        .marker-approved { background-color: #15803d; }
        .marker-rejected { background-color: #b91c1c; }
        
        .timeline-content {
            background-color: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
        }
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
            flex-wrap: wrap;
            gap: 6px;
        }
        .timeline-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }
        .timeline-date {
            font-size: 11px;
            color: #9ca3af;
        }
        .timeline-note {
            font-size: 12.5px;
            color: #4b5563;
            background-color: #fff;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #d1d5db;
            margin-top: 6px;
        }
        .timeline-note-rejected {
            border-left-color: #ef4444;
            background-color: #fef2f2;
            color: #991b1b;
        }
        .timeline-note-approved {
            border-left-color: #10b981;
            background-color: #f0fdf4;
            color: #065f46;
        }
        .timeline-actor {
            font-size: 11px;
            color: #6b7280;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <!-- Header -->
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <span>Beranda</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Riwayat Skripsi</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Detail & Timeline</span>
                </div>
                <h1>Detail Proposal Skripsi</h1>
                <p>Pantau tahapan evaluasi dan lini masa persetujuan usulan skripsi Anda</p>
            </div>
            <a href="{{ route('student.skripsi.history') }}" class="btn-secondary" id="btn-back">
                <i class="ti ti-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="grid-layout">
            <!-- Details -->
            <div>
                <div class="card">
                    <div class="card-title">
                        <span>Data Usulan</span>
                        @php
                            $statusClass = match($skripsi->status) {
                                'pending' => 'status-pending',
                                'approved' => 'status-approved',
                                'rejected' => 'status-rejected',
                                default => ''
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $skripsi->status == 'pending' ? 'Pending' : ($skripsi->status == 'approved' ? 'Approved' : 'Rejected') }}</span>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="label">Dosen Pembimbing</div>
                            <div class="val">{{ $skripsi->supervisor->name ?? '-' }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="label">Tanggal Pengajuan</div>
                            <div class="val">{{ $skripsi->submission_date ? $skripsi->submission_date->format('d M Y') : '-' }}</div>
                        </div>
                    </div>

                    <div class="section-title">Judul Skripsi</div>
                    <div style="font-size:16px; font-weight:600; color:#1a1a2e; margin-bottom: 20px;">{{ $skripsi->title }}</div>

                    <div class="section-title">Deskripsi</div>
                    <div class="desc-box">{{ $skripsi->description }}</div>

                    @if($skripsi->suggestion_supervisor)
                        <div class="section-title">Rekomendasi Dosen Pembimbing Alternatif</div>
                        <div style="font-size:13.5px; color:#374151; margin-bottom: 20px;">
                            {{ \App\Models\Lecturer::find($skripsi->suggestion_supervisor)->name ?? '-' }}
                        </div>
                    @endif

                    @if($skripsi->elective_courses)
                        <div class="section-title">Mata Kuliah Pilihan Pendukung</div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Mata Kuliah</th>
                                    <th style="width: 15%; text-align: center;">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($skripsi->elective_courses as $item)
                                    <tr>
                                        <td>{{ $courses[$item['id']] ?? 'Mata Kuliah #'.$item['id'] }}</td>
                                        <td style="text-align: center; font-weight: 600; color: #185FA5;">{{ $item['grade'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div>
                <div class="card">
                    <div class="card-title">Timeline Persetujuan</div>
                    
                    @if($skripsi->histories->isEmpty())
                        <p style="text-align:center; padding:20px; color:#9ca3af; font-size:13px;">Belum ada riwayat timeline.</p>
                    @else
                        <div class="timeline">
                            @foreach($skripsi->histories as $history)
                                <div class="timeline-item">
                                    @php
                                        $markerClass = 'marker-pending';
                                        $markerIcon = 'fa-paper-plane';
                                        if ($history->status_after === 'approved') {
                                            $markerClass = 'marker-approved';
                                            $markerIcon = 'fa-check';
                                        } elseif ($history->status_after === 'rejected') {
                                            $markerClass = 'marker-rejected';
                                            $markerIcon = 'fa-xmark';
                                        }
                                    @endphp
                                    <div class="timeline-marker {{ $markerClass }}">
                                        <i class="fa-solid {{ $markerIcon }}"></i>
                                    </div>

                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <span class="timeline-title">
                                                @if(is_null($history->status_before))
                                                    Pengajuan Awal
                                                @elseif($history->status_after === 'approved')
                                                    Disetujui
                                                @elseif($history->status_after === 'rejected')
                                                    Ditolak
                                                @else
                                                    Status Diperbarui
                                                @endif
                                            </span>
                                            <span class="timeline-date">{{ $history->created_at->format('d M Y H:i') }}</span>
                                        </div>

                                        @if($history->note)
                                            <div class="timeline-note {{ $history->status_after === 'approved' ? 'timeline-note-approved' : ($history->status_after === 'rejected' ? 'timeline-note-rejected' : '') }}">
                                                {{ $history->note }}
                                            </div>
                                        @endif

                                        @if($history->handler)
                                            <div class="timeline-actor">
                                                <i class="fa-solid fa-user-shield"></i> Dievaluasi oleh: {{ $history->handler->name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
