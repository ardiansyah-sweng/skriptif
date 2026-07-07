<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Topik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .status-tag { font-size: 12px; padding: 6px 10px; border-radius: 9999px; }
        .status-open { background: #ecfdf5; color: #166534; }
        .status-filled { background: #e2e8f0; color: #475569; }
        .status-closed { background: #fee2e2; color: #991b1b; }
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-4 d-flex justify-content-between align-items-start">
            <div>
                <h1 class="main-title">{{ $topic->title }}</h1>
                <p class="text-muted">Topik oleh {{ $topic->lecturer->name }} ({{ $topic->lecturer->lecturer_id }})</p>
            </div>
            <div>
                <a href="{{ route('topic-board.index') }}" class="btn btn-secondary">Kembali ke Board</a>
            </div>
        </div>

        <div class="content-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-column flex-md-row">
                <div>
                    <h5>Deskripsi</h5>
                    <p>{{ $topic->description }}</p>
                    <h6>Persyaratan</h6>
                    <p style="white-space: pre-line;">{{ $topic->requirements ?? '-' }}</p>
                </div>
                <div class="border rounded-3 p-3 bg-light" style="min-width: 220px;">
                    <p class="mb-2"><strong>Status</strong></p>
                    <span class="status-tag status-{{ $topic->status }}">{{ ucfirst($topic->status) }}</span>
                    <hr>
                    <p class="mb-1"><strong>Kapasitas</strong></p>
                    <p>{{ $topic->applied_count }} / {{ $topic->capacity }}</p>
                    <p class="mb-1"><strong>Deadline</strong></p>
                    <p>{{ $topic->deadline ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="content-card p-4">
            <h5 class="mb-3">Ajukan Diri</h5>
            <form action="{{ route('topic-board.apply', $topic->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="applicant_name" class="form-control" value="{{ old('applicant_name') }}" required placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIM</label>
                        <input type="text" name="applicant_nim" class="form-control" value="{{ old('applicant_nim') }}" required placeholder="Masukkan NIM">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan Persyaratan</label>
                        <textarea name="requirements_note" class="form-control" rows="4" placeholder="Tuliskan dokumen yang dilampirkan dan alasan sesuai syarat" required>{{ old('requirements_note') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dokumen Pendukung</label>
                        <input type="file" name="document" class="form-control" required>
                        <div class="form-text text-muted">Unggah dokumen sesuai syarat: PDF, DOC, DOCX, atau ZIP maksimal 10MB.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Pesan / Catatan</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Alasan atau catatan singkat">{{ old('message') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Ajukan Diri</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
