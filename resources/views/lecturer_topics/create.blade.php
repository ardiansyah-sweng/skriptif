<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Topik Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .form-label { font-weight: 600; color: #334155; }
        .form-control { border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 900px;">
        <div class="mb-4">
            <h1 class="main-title">Tambah Topik Dosen</h1>
            <p class="text-muted">Masukkan informasi topik skripsi atau proyek yang ditawarkan oleh dosen.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="content-card p-4">
            <form action="{{ route('lecturer-topics.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Dosen</label>
                    <select name="lecturer_id" class="form-select" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->name }} ({{ $lecturer->lecturer_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Topik</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kebutuhan / Persyaratan</label>
                    <textarea name="requirements" class="form-control" rows="3">{{ old('requirements') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Batas Waktu</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kapasitas Mahasiswa</label>
                        <input type="number" name="capacity" class="form-control" min="1" value="{{ old('capacity', 1) }}">
                    </div>
                </div>

                <div class="mb-3 mt-4 d-flex gap-2">
                    <a href="{{ route('lecturer-topics.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Topik</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
