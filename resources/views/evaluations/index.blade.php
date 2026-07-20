<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 1100px; margin: 0 auto; }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 0.5px solid #e5e7eb;
        }

        .crumb {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-head h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }

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

        .alert-success {
            background: #E6F7EE;
            border: 0.5px solid #A6E3C2;
            color: #16794A;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .count-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 20px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }
        .count-pill strong { color: #1a1a2e; font-weight: 500; }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 28px 0 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .table-wrap {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }

        thead { background: #f9fafb; }
        thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 0.5px solid #e5e7eb;
            text-align: left;
        }

        tbody tr { border-bottom: 0.5px solid #f0f0f0; transition: background .1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f9fafb; }
        tbody td { padding: 13px 16px; vertical-align: middle; }

        .no-col { color: #9ca3af; font-size: 12px; }
        .date-col { font-size: 12px; color: #6b7280; }

        .title-cell { font-size: 13px; color: #1a1a2e; font-weight: 500; }
        .sub-cell { font-size: 12px; color: #6b7280; margin-top: 2px; }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .role-pembimbing { background: #E6F1FB; color: #0C447C; }
        .role-penguji { background: #FFF6E0; color: #A66A00; }

        .grade-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }
        .grade-A { background: #E6F7EE; color: #16794A; }
        .grade-B { background: #E6F1FB; color: #0C447C; }
        .grade-C { background: #FFF6E0; color: #A66A00; }
        .grade-D { background: #FCEBEB; color: #A32D2D; }
        .grade-E { background: #F3E8FD; color: #6B21A8; }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 6px;
            font-size: 12px;
            color: #A32D2D;
            cursor: pointer;
        }
        .btn-del:hover { background: #FCEBEB; border-color: #F09595; }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 6px;
            font-size: 12px;
            color: #185FA5;
            text-decoration: none;
        }
        .btn-edit:hover { background: #E6F1FB; border-color: #85B7EB; }
        .action-wrap { display: flex; gap: 6px; }

        .empty {
            text-align: center;
            padding: 56px 16px;
            color: #9ca3af;
        }
        .empty i { font-size: 36px; display: block; margin-bottom: 10px; opacity: .4; }
        .empty p { font-size: 14px; }

        .rekap-total {
            font-weight: 700;
            color: #185FA5;
        }
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
                    <span>Evaluasi Skripsi</span>
                </div>
                <h1>Evaluasi Skripsi</h1>
                <p>Hasil penilaian dosen pembimbing &amp; dosen penguji terhadap skripsi mahasiswa</p>
            </div>
            <a href="{{ route('evaluations.create') }}" class="btn-primary">
                <i class="ti ti-plus"></i> Tambah Evaluasi
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="count-pill">
            <i class="ti ti-clipboard-check" style="font-size:13px"></i>
            <strong>{{ $evaluations->count() }}</strong> evaluasi tercatat
        </div>

        <div class="table-wrap">
            @if($evaluations->isEmpty())
                <div class="empty">
                    <i class="ti ti-clipboard-off"></i>
                    <p>Belum ada data evaluasi.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px">No</th>
                            <th>Mahasiswa / Skripsi</th>
                            <th>Peran</th>
                            <th>Dosen</th>
                            <th style="width:70px">Nilai</th>
                            <th style="width:60px">Grade</th>
                            <th style="width:70px">Bobot</th>
                            <th style="width:80px">Nilai Akhir</th>
                            <th style="width:120px">Tanggal</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $index => $evaluation)
                            <tr>
                                <td class="no-col">{{ $index + 1 }}</td>
                                <td>
                                    <div class="title-cell">{{ $evaluation->skripsi->student->name ?? '-' }}</div>
                                    <div class="sub-cell">{{ $evaluation->skripsi->title ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="role-badge role-{{ $evaluation->role }}">
                                        {{ $evaluation->role === 'pembimbing' ? 'Pembimbing' : 'Penguji' }}
                                    </span>
                                </td>
                                <td>{{ $evaluation->lecturer->name ?? '-' }}</td>
                                <td>{{ number_format($evaluation->score, 1) }}</td>
                                <td>
                                    <span class="grade-badge grade-{{ $evaluation->grade }}">{{ $evaluation->grade }}</span>
                                </td>
                                <td>{{ number_format($evaluation->weight, 0) }}%</td>
                                <td>{{ number_format($evaluation->final_score, 1) }}</td>
                                <td class="date-col">{{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d M Y') }}</td>
                                <td>
                                    <div class="action-wrap">
                                        <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn-edit">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('evaluations.destroy', $evaluation->id) }}" method="POST" onsubmit="return confirm('Hapus evaluasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-del">
                                                <i class="ti ti-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if(!$evaluations->isEmpty())
            <div class="section-title"><i class="ti ti-report"></i> Rekap Penilaian per Skripsi</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Mahasiswa / Skripsi</th>
                            <th style="width:180px">Pembimbing</th>
                            <th style="width:180px">Penguji</th>
                            <th style="width:130px">Total Nilai Semprog</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekap as $row)
                            <tr>
                                <td>
                                    <div class="title-cell">{{ $row['skripsi']->student->name ?? '-' }}</div>
                                    <div class="sub-cell">{{ $row['skripsi']->title ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($row['pembimbing'])
                                        {{ $row['pembimbing']->lecturer->name ?? '-' }}<br>
                                        <span class="sub-cell">{{ number_format($row['pembimbing']->score, 1) }} × {{ number_format($row['pembimbing']->weight, 0) }}% = {{ number_format($row['pembimbing']->final_score, 1) }}</span>
                                    @else
                                        <span class="rekap-muted">Belum dinilai</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row['penguji'])
                                        {{ $row['penguji']->lecturer->name ?? '-' }}<br>
                                        <span class="sub-cell">{{ number_format($row['penguji']->score, 1) }} × {{ number_format($row['penguji']->weight, 0) }}% = {{ number_format($row['penguji']->final_score, 1) }}</span>
                                    @else
                                        <span class="rekap-muted">Belum dinilai</span>
                                    @endif
                                </td>
                                <td class="rekap-total">{{ number_format($row['total'], 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>