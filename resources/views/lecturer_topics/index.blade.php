<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Topik Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
        .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .meta-text { font-size: 12px; color: #64748b; }
        .btn-detail-action { background-color: #64748b; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
        .btn-edit-action { background-color: #3b82f6; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
        .btn-delete-action { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
        .btn-add-action { background-color: #10b981; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 8px 16px; border: none; text-decoration: none; }
        .btn-add-action:hover { background-color: #0f766e; }
        .btn-detail-action:hover { background-color: #475569; }
        .btn-edit-action:hover { background-color: #2563eb; }
        .btn-delete-action:hover { background-color: #dc2626; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Papan Topik Dosen</h1>
                <p class="sub-title">Kelola topik skripsi dan proyek yang ditawarkan oleh dosen.</p>
            </div>
            <div>
                <a href="{{ route('lecturer-topics.create') }}" class="btn-add-action">
                    <i class="fa-solid fa-plus"></i> Tambah Topik Baru
                </a>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark">Daftar Topik</span>
                <span class="meta-text"><i class="fa-solid fa-book-bookmark me-1"></i> {{ $topics->count() }} topik</span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 24%">Judul Topik</th>
                            <th style="width: 20%">Dosen</th>
                            <th style="width: 12%">Status</th>
                            <th style="width: 10%">Kapsitas</th>
                            <th style="width: 29%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topics as $index => $topic)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $topic->title }}</div>
                                <div class="meta-text">{{ Str::limit($topic->description, 80) }}</div>
                            </td>
                            <td>
                                <div class="meta-text">{{ $topic->lecturer->name }}</div>
                                <div class="meta-text">{{ $topic->lecturer->lecturer_id }}</div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $topic->status === 'open' ? 'success' : ($topic->status === 'filled' ? 'secondary' : 'danger') }}">{{ ucfirst($topic->status) }}</span>
                            </td>
                            <td>
                                <div class="meta-text">{{ $topic->applied_count }} / {{ $topic->capacity }}</div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('lecturer-topics.show', $topic->id) }}" class="btn-detail-action">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('lecturer-topics.edit', $topic->id) }}" class="btn-edit-action">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('lecturer-topics.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Hapus topik ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-action">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Tidak ada topik dosen.
                            </td>
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