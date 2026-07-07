<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah Pilihan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 600px; margin: 0 auto; }

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

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: transparent;
            color: #6b7280;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-back:hover { background: #f4f6f9; }

        .card {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 9px 12px;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            color: #1a1a2e;
            background: #fff;
            outline: none;
            transition: border-color .15s;
        }
        .form-group input:focus { border-color: #185FA5; }

        .form-group .hint {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .error {
            font-size: 12px;
            color: #A32D2D;
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 0.5px solid #e5e7eb;
        }

        .btn-cancel {
            padding: 9px 18px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            color: #6b7280;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-cancel:hover { background: #f4f6f9; }

        .btn-submit {
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
        }
        .btn-submit:hover { background: #0C447C; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <a href="{{ route('dashboard') }}" style="color:#9ca3af;text-decoration:none">Beranda</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <a href="{{ route('elective-courses.index') }}" style="color:#9ca3af;text-decoration:none">Mata Kuliah Pilihan</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Edit</span>
                </div>
                <h1>Edit Mata Kuliah</h1>
                <p>Ubah nama mata kuliah pilihan</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="ti ti-arrow-left"></i> Dashboard
                </a>
                <a href="{{ route('elective-courses.index') }}" class="btn-back">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('elective-courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="courses">Nama Mata Kuliah</label>
                    <input
                        type="text"
                        id="courses"
                        name="courses"
                        value="{{ old('courses', $course->courses) }}"
                        placeholder="Contoh: Pemrograman Mobile"
                        autofocus
                    >
                    <span class="hint">Ubah nama mata kuliah pilihan</span>
                    @error('courses')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('elective-courses.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="ti ti-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>