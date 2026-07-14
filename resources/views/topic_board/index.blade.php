<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Topik Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .card-board { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .status-tag { font-size: 12px; padding: 6px 10px; border-radius: 9999px; }
        .status-open { background: #ecfdf5; color: #166534; }
        .status-filled { background: #e2e8f0; color: #475569; }
        .status-closed { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1100px;">
        <div class="mb-4">
            <h1 class="main-title">Papan Topik Mahasiswa</h1>
            <p class="text-muted">Temukan topik skripsi dan proyek yang ditawarkan oleh dosen.</p>
        </div>

        <form class="row g-3 mb-4" action="{{ route('topic-board.index') }}" method="GET">
            <div class="col-md-10">
                <input type="text" name="q" class="form-control" placeholder="Cari topik atau kata kunci..." value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <div class="row g-4">
            @forelse($topics as $topic)
            <div class="col-lg-6">
                <div class="card-board p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="fw-bold">{{ $topic->title }}</h4>
                            <p class="mb-1 text-muted">Dosen: {{ $topic->lecturer->name }}</p>
                            <p class="text-muted mb-0">{{ Str::limit($topic->description, 140) }}</p>
                        </div>
                        <span class="status-tag status-{{ $topic->status }}">{{ ucfirst($topic->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            <div>Deadline: {{ $topic->deadline ?? '-' }}</div>
                        </div>
                        <a href="{{ route('topic-board.show', $topic->id) }}" class="btn btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card-board p-5 text-center text-muted">
                    <i class="fa-regular fa-folder-open d-block mb-3" style="font-size: 32px;"></i>
                    Tidak ada topik terbuka saat ini.
                </div>
            </div>
            @endforelse
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>