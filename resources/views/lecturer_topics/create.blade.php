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
            <p class="text-muted">Masukkan satu atau lebih topik skripsi yang ditawarkan oleh dosen.</p>
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
                    <label class="form-label">Judul-Judul Topik</label>
                    <div id="topics-container">
                        <div class="topic-item border rounded-3 p-3 mb-3">
                            <div class="mb-2">
                                <input type="text" name="titles[]" class="form-control" placeholder="Judul topik 1" required>
                            </div>
                            <div class="mb-2">
                                <textarea name="descriptions[]" class="form-control" rows="3" placeholder="Deskripsi topik 1" required></textarea>
                            </div>
                            <div class="mb-2">
                                <textarea name="requirements[]" class="form-control" rows="2" placeholder="Persyaratan (opsional)"></textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="number" name="capacities[]" class="form-control" placeholder="Kapasitas" value="1" min="1">
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="deadlines[]" class="form-control" placeholder="Batas waktu (opsional)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addTopic()">
                        <i class="fa-solid fa-plus"></i> Tambah Judul Lain
                    </button>
                </div>

                <div class="mb-3 mt-4 d-flex gap-2">
                    <a href="{{ route('lecturer-topics.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Semua Topik</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        let topicCount = 1;
        function addTopic() {
            topicCount++;
            const container = document.getElementById('topics-container');
            const div = document.createElement('div');
            div.className = 'topic-item border rounded-3 p-3 mb-3';
            div.innerHTML = `
                <div class="mb-2">
                    <input type="text" name="titles[]" class="form-control" placeholder="Judul topik ${topicCount}" required>
                </div>
                <div class="mb-2">
                    <textarea name="descriptions[]" class="form-control" rows="3" placeholder="Deskripsi topik ${topicCount}" required></textarea>
                </div>
                <div class="mb-2">
                    <textarea name="requirements[]" class="form-control" rows="2" placeholder="Persyaratan (opsional)"></textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="number" name="capacities[]" class="form-control" placeholder="Kapasitas" value="1" min="1">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="deadlines[]" class="form-control" placeholder="Batas waktu (opsional)">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.topic-item').remove()">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>opic