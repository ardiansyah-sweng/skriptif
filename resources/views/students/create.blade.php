<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
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

        .crumb {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 0.5px solid #e5e7eb;
        }

        .page-head h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }

        .form-container {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 13px;
            color: #374151;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            color: #1a1a2e;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #185FA5;
            box-shadow: 0 0 0 3px rgba(24, 95, 165, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 0.5px solid #e5e7eb;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: #185FA5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-save:hover { background: #0C447C; }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: #f3f4f6;
            color: #6b7280;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-cancel:hover { background: #e5e7eb; }

        .error-message {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 0.5px solid #fecaca;
        }

        .form-group.error input,
        .form-group.error select {
            border-color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="crumb">
            <i class="ti ti-home" style="font-size: 12px;"></i>
            <span>Dashboard</span>
            <span style="margin: 0 4px;">/</span>
            <a href="{{ route('students.index') }}" style="color: #0ea5e9; text-decoration: none;">Mahasiswa</a>
            <span style="margin: 0 4px;">/</span>
            <span>Tambah</span>
        </div>

        <div class="page-head">
            <div>
                <h1>Tambah Mahasiswa Baru</h1>
                <p>Masukkan data mahasiswa yang akan ditambahkan</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error">
            <strong>✗ Validasi Gagal!</strong> Silakan periksa kembali data yang Anda masukkan.
        </div>
        @endif

        <div class="form-container">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <div class="form-group {{ $errors->has('student_id') ? 'error' : '' }}">
                    <label>
                        NIM <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="student_id" 
                        value="{{ old('student_id') }}"
                        placeholder="Contoh: 2021001"
                        required>
                    @if($errors->has('student_id'))
                    <div class="error-message">
                        <i class="ti ti-alert-circle" style="font-size: 12px;"></i>
                        {{ $errors->first('student_id') }}
                    </div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                    <label>
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Contoh: Ahmad Rizki Pratama"
                        required>
                    @if($errors->has('name'))
                    <div class="error-message">
                        <i class="ti ti-alert-circle" style="font-size: 12px;"></i>
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
                    <label>
                        Email <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Contoh: user@student.uad.ac.id"
                        required>
                    @if($errors->has('email'))
                    <div class="error-message">
                        <i class="ti ti-alert-circle" style="font-size: 12px;"></i>
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('year_entrance') ? 'error' : '' }}">
                    <label>
                        Tahun Masuk <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="year_entrance" 
                        value="{{ old('year_entrance') }}"
                        placeholder="Contoh: 2021"
                        min="2000" 
                        max="2099"
                        required>
                    @if($errors->has('year_entrance'))
                    <div class="error-message">
                        <i class="ti ti-alert-circle" style="font-size: 12px;"></i>
                        {{ $errors->first('year_entrance') }}
                    </div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('status') ? 'error' : '' }}">
                    <label>
                        Status <span class="required">*</span>
                    </label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @if($errors->has('status'))
                    <div class="error-message">
                        <i class="ti ti-alert-circle" style="font-size: 12px;"></i>
                        {{ $errors->first('status') }}
                    </div>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="ti ti-check" style="font-size: 15px;"></i>
                        Simpan
                    </button>
                    <a href="{{ route('students.index') }}" class="btn-cancel">
                        <i class="ti ti-x" style="font-size: 15px;"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
