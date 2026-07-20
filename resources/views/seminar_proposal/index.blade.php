<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkas Seminar Proposal — Thesis System</title>
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
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .empty-state { text-align: center; padding: 40px; color: #6b7280; font-size: 13px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; }
        th { background-color: #f8fafc; font-weight: 500; color: #374151; border-bottom: 1px solid #e5e7eb; }
        tr { border-bottom: 0.5px solid #e5e7eb; }
        tr:hover { background-color: #f8fafc; }

        .status-uploaded { background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-partial { background-color: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-missing { background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .file-link { font-size: 12px; color: #185FA5; text-decoration: none; }
        .file-link:hover { text-decoration: underline; }

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
                    <span>Home</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Seminar Proposal</span>
                </div>
                <h1>Berkas Syarat Seminar Proposal</h1>
                <p>Daftar mahasiswa dan status kelengkapan berkas pengajuan seminar proposal</p>
            </div>
            <a href="{{ route('seminar-proposal.create') }}" class="btn-primary">
                <i class="ti ti-upload"></i> Upload Berkas
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-title">Daftar Mahasiswa</div>

            @if($students->isEmpty())
                <div class="empty-state">Belum ada mahasiswa yang mengajukan skripsi.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Dosen Pembimbing</th>
                            <th>Kelengkapan Berkas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                            @php
                                $document = $s->skripsi->seminarProposalDocument ?? null;
                                $total = count($documentFields);
                                $completed = 0;
                                foreach (array_keys($documentFields) as $field) {
                                    if ($document && $document->$field) {
                                        $completed++;
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $s->student_id }}</td>
                                <td>{{ $s->name }}</td>
                                <td>
                                    @if($s->skripsi->supervisor)
                                        {{ $s->skripsi->supervisor->name }}
                                    @else
                                        <span style="color:#9ca3af;">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($completed === $total)
                                        <span class="status-uploaded">Lengkap ({{ $completed }}/{{ $total }})</span>
                                    @elseif($completed > 0)
                                        <span class="status-partial">{{ $completed }}/{{ $total }} berkas</span>
                                    @else
                                        <span class="status-missing">Belum ada berkas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('seminar-proposal.create', ['student_id' => $s->id]) }}" class="file-link">Kelola Berkas</a>
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
