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

        .wrap { max-width: 720px; margin: 0 auto; }

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

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
        }
        .role-pembimbing { background: #E6F1FB; color: #0C447C; }
        .role-penguji { background: #FFF6E0; color: #A66A00; }

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
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 14px;
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

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th {
            padding: 8px 0;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 0.5px solid #e5e7eb;
            text-align: left;
        }
        thead th.num { text-align: center; }
        tbody td {
            padding: 10px 0;
            border-bottom: 0.5px solid #f0f0f0;
            vertical-align: top;
            font-size: 12.5px;
        }
        tbody td.num { text-align: center; }
        tbody tr:last-child td { border-bottom: none; }

        tfoot td {
            padding: 12px 0 0;
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
        }
        tfoot td.num { text-align: center; color: #185FA5; }

        .notes-box {
            margin-top: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 13px;
            color: #374151;
            line-height: 1.5;
        }

        .actions { display: flex; gap: 8px; margin-top: 4px; margin-bottom: 24px; }

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

        .rekap-muted { color: #9ca3af; font-style: italic; font-size: 12px; }
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
                <span class="role-badge role-{{ $evaluation->role }}">
                    {{ $evaluation->role === 'pembimbing' ? 'Dosen Pembimbing' : 'Dosen Penguji' }}
                </span>
            </div>
            <div class="grade-badge-lg grade-{{ $evaluation->grade }}">{{ $evaluation->grade }}</div>
        </div>

        <div class="card">
            <div class="row">
                <span class="label">Judul Skripsi</span>
                <span class="value">{{ $evaluation->skripsi->title ?? '-' }}</span>
            </div>
            <div class="row">
                <span class="label">Dosen</span>
                <span class="value">{{ $evaluation->lecturer->name ?? '-' }}</span>
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
        </div>

        <div class="card">
            <div class="card-title">Komponen Penilaian</div>
            <table>
                <thead>
                    <tr>
                        <th class="num" style="width:28px">No</th>
                        <th>Unsur Penilaian</th>
                        <th class="num" style="width:70px">Range Nilai</th>
                        <th class="num" style="width:60px">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluation->componentScores as $index => $componentScore)
                        <tr>
                            <td class="num">{{ $index + 1 }}</td>
                            <td>{{ $componentScore->component->name ?? '-' }}</td>
                            <td class="num">
                                {{ rtrim(rtrim($componentScore->component->min_score, '0'), '.') }} -
                                {{ rtrim(rtrim($componentScore->component->max_score, '0'), '.') }}
                            </td>
                            <td class="num">{{ number_format($componentScore->score, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Nilai</td>
                        <td class="num">{{ number_format($evaluation->score, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card">
            <div class="card-title">Rekap Penilaian</div>
            <table>
                <thead>
                    <tr>
                        <th>Peran</th>
                        <th>Dosen</th>
                        <th class="num" style="width:50px">Nilai</th>
                        <th class="num" style="width:55px">Bobot</th>
                        <th class="num" style="width:70px">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pembimbing = $evaluation->role === 'pembimbing' ? $evaluation : $counterpart;
                        $penguji = $evaluation->role === 'penguji' ? $evaluation : $counterpart;
                    @endphp
                    <tr>
                        <td>Pembimbing</td>
                        <td>{{ $pembimbing->lecturer->name ?? '-' }}</td>
                        <td class="num">{{ $pembimbing ? number_format($pembimbing->score, 0) : '-' }}</td>
                        <td class="num">{{ $pembimbing ? number_format($pembimbing->weight, 0) . '%' : '-' }}</td>
                        <td class="num">{{ $pembimbing ? number_format($pembimbing->final_score, 1) : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Penguji</td>
                        <td>{{ $penguji->lecturer->name ?? '-' }}</td>
                        <td class="num">{{ $penguji ? number_format($penguji->score, 0) : '-' }}</td>
                        <td class="num">{{ $penguji ? number_format($penguji->weight, 0) . '%' : '-' }}</td>
                        <td class="num">{{ $penguji ? number_format($penguji->final_score, 1) : '-' }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total Nilai Sempro</td>
                        <td class="num">
                            {{ number_format((float) ($pembimbing->final_score ?? 0) + (float) ($penguji->final_score ?? 0), 1) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
            @if(!$counterpart)
                <p class="rekap-muted" style="margin-top:10px">
                    Menunggu penilaian dari {{ $evaluation->role === 'pembimbing' ? 'Dosen Penguji' : 'Dosen Pembimbing' }}.
                </p>
            @endif
        </div>

        <div class="actions">
            <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn-primary">
                <i class="ti ti-edit"></i> Edit
            </a>
            <a href="{{ route('evaluations.index') }}" class="btn-cancel">Kembali</a>
        </div>
    </div>
</body>
</html>