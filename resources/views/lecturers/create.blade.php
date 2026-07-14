<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        .sub-title {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }

        .content-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            padding: 32px;
        }

        /* Form Specific Styles */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 10px 16px;
            font-size: 14px;
            color: #0f172a;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* Buttons */
        .btn-back-custom {
            background-color: transparent;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            padding: 10px 24px;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-back-custom:hover {
            background-color: #f1f5f9;
            color: #334155;
        }

        .btn-save-action {
            background-color: #3b82f6;
            color: white;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            padding: 10px 24px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-save-action:hover {
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container py-5" style="max-width: 700px;">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Tambah Dosen Baru</h1>
                <p class="sub-title">Masukkan informasi lengkap untuk data dosen.</p>
            </div>
            <a href="{{ route('lecturers.index') }}" class="btn-back-custom">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="content-card">
            <form action="{{ route('lecturers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">NIDN / ID DOSEN <span
                            class="text-danger">*</span></label>
                    <input type="text" name="lecturer_id" id="lecturer_id"
                        class="form-control @error('lecturer_id') is-invalid @enderror" value="{{ old('lecturer_id') }}"
                        placeholder="Contoh: 0523048501 atau LCT001" required>
                    @error('lecturer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">NAMA LENGKAP <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                        placeholder="Contoh: Prof. Drs. Ir. Abdul Fadlil, M.T., Ph.D." required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">EMAIL DOSEN <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        placeholder="Contoh: nama.dosen@tif.uad.ac.id" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="expertise" class="form-label">BIDANG KEAHLIAN</label>
                    <input type="text" name="expertise" id="expertise"
                        class="form-control @error('expertise') is-invalid @enderror" value="{{ old('expertise') }}"
                        placeholder="Contoh: Computer Vision & AI">
                    @error('expertise')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="max_supervisors" class="form-label">MAKS. MAHASISWA PER ANGKATAN</label>
                    <input type="number" name="max_supervisors" id="max_supervisors"
                        class="form-control @error('max_supervisors') is-invalid @enderror"
                        value="{{ old('max_supervisors', 3) }}" min="1">
                    <div class="form-text text-muted" style="font-size: 12px; margin-top: 6px;">Secara default diisi 3
                        mahasiswa.</div>
                    @error('max_supervisors')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top: 1px solid #e2e8f0;">
                    <a href="{{ route('lecturers.index') }}" class="btn-back-custom">Batal</a>
                    <button type="submit" class="btn-save-action">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
