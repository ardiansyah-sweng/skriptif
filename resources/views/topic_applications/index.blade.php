<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aplikasi Topik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1000px;">
        <div class="mb-4 d-flex justify-content-between align-items-start">
            <div>
                <h1 class="main-title">Riwayat Aplikasi Topik</h1>
                <p class="text-muted">Lihat pengajuan topik aplikasi dan status persetujuannya.</p>
            </div>
            <a href="{{ route('topic-board.index') }}" class="btn btn-secondary">Lihat Board Topik</a>
        </div>

        <div class="content-card p-4">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Mahasiswa</th>
                            <th>Topik</th>
                            <th>Status</th>
                            <th>Persyaratan</th>
                            <th>Pesan</th>
                            <th>Dokumen</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $index => $application)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->student?->name }} ({{ $application->student?->student_id }})</td>
                            <td>{{ $application->lecturerTopic->title }}</td>
                            <td>{{ ucfirst($application->status) }}</td>
                            <td>{{ $application->requirements_note ?? '-' }}</td>
                            <td>{{ $application->message ?? '-' }}</td>
                            <td>
                                @if($application->document_path)
                                    <a href="{{ asset('storage/' . $application->document_path) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada aplikasi topik.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>