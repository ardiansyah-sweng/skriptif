<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Topik Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .badge-status { font-size: 13px; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1000px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Detail Topik</h1>
                <p class="text-muted">Informasi lengkap dan daftar aplikasi mahasiswa.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('lecturer-topics.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('lecturer-topics.edit', $topic->id) }}" class="btn btn-primary">Edit Topik</a>
            </div>
        </div>

        <div class="content-card p-4 mb-4">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="fw-bold">{{ $topic->title }}</h2>
                    <p class="text-muted mb-2">Dosen: {{ $topic->lecturer->name }} ({{ $topic->lecturer->lecturer_id }})</p>
                    <p>{{ $topic->description }}</p>
                    <p><strong>Persyaratan:</strong></p>
                    <p style="white-space: pre-line;">{{ $topic->requirements ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <p class="mb-2"><strong>Status</strong></p>
                        <span class="badge bg-{{ $topic->status === 'open' ? 'success' : ($topic->status === 'filled' ? 'secondary' : 'danger') }} badge-status">{{ ucfirst($topic->status) }}</span>
                        <hr>
                        <p class="mb-1"><strong>Kapasitas</strong></p>
                        <p>{{ $topic->applied_count }} / {{ $topic->capacity }}</p>
                        <p class="mb-1"><strong>Batas waktu</strong></p>
                        <p>{{ $topic->deadline ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card p-4">
            <h5 class="mb-3">Aplikasi Mahasiswa</h5>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Mahasiswa</th>
                            <th>Status</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topic->applications as $index => $application)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->student?->name ?? $application->applicant_name }} ({{ $application->student?->student_id ?? $application->applicant_nim }})</td>
                            <td>{{ ucfirst($application->status) }}</td>
                            <td>{{ $application->message ?? '-' }}</td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($application->status === 'pending')
                                    <form action="{{ route('topic-applications.approve', $application->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui aplikasi ini?')">Setujui</button>
                                    </form>
                                    <form action="{{ route('topic-applications.reject', $application->id) }}" method="POST" style="display:inline" class="ms-1">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak aplikasi ini?')">Tolak</button>
                                    </form>
                                    <form action="{{ route('topic-applications.destroy', $application->id) }}" method="POST" style="display:inline" class="ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus aplikasi ini?')">Hapus</button>
                                    </form>
                                @else
                                    <form action="{{ route('topic-applications.destroy', $application->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus aplikasi ini?')">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada aplikasi.</td>
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
