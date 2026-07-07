<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background:
                radial-gradient(circle at top left, rgba(24, 95, 165, 0.14), transparent 28%),
                radial-gradient(circle at bottom right, rgba(250, 204, 21, 0.16), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            padding: 32px 20px 40px;
        }
        .wrap { max-width: 820px; margin: 0 auto; }
        .hero {
            display: flex; justify-content: space-between; gap: 16px; align-items: flex-end;
            margin-bottom: 20px; padding-bottom: 18px; border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        .crumb { display: inline-flex; gap: 6px; align-items: center; font-size: 12px; color: #64748b; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 28px; letter-spacing: -0.03em; }
        .sub { margin: 8px 0 0; color: #64748b; font-size: 14px; }
        .back {
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none; background: #fff;
            color: #334155; border: 1px solid #dbe3ee; border-radius: 12px; padding: 11px 14px; font-weight: 600;
        }
        .back:hover { background: #f8fafc; }
        .card {
            background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08); overflow: hidden;
        }
        .card-head { padding: 18px 20px; border-bottom: 1px solid #eef2f7; background: #fbfdff; }
        .card-head strong { display: block; font-size: 16px; }
        .card-head span { color: #64748b; font-size: 13px; }
        form { padding: 20px; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 8px; }
        .field.full { grid-column: 1 / -1; }
        label { font-size: 13px; font-weight: 700; color: #334155; }
        input, select {
            width: 100%; border: 1px solid #dbe3ee; border-radius: 12px; padding: 12px 14px;
            font-size: 14px; outline: none; background: #fff;
        }
        input:focus, select:focus { border-color: #185FA5; box-shadow: 0 0 0 4px rgba(24, 95, 165, 0.12); }
        .hint { font-size: 12px; color: #94a3b8; }
        .error { font-size: 12px; color: #b91c1c; }
        .actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }
        .ghost, .primary {
            display: inline-flex; align-items: center; gap: 8px; border-radius: 12px; padding: 12px 16px;
            text-decoration: none; font-weight: 700; border: 1px solid transparent; cursor: pointer;
        }
        .ghost { background: #fff; border-color: #dbe3ee; color: #334155; }
        .ghost:hover { background: #f8fafc; }
        .primary { background: #185FA5; color: #fff; }
        .primary:hover { background: #0c447c; }
        @media (max-width: 720px) {
            body { padding: 18px 14px 28px; }
            .hero { flex-direction: column; align-items: stretch; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <div>
                <div class="crumb">
                    <i class="ti ti-home"></i>
                    <a href="{{ route('dashboard') }}" style="color:#64748b;text-decoration:none">Beranda</a>
                    <i class="ti ti-chevron-right"></i>
                    <a href="{{ route('students.index') }}" style="color:#64748b;text-decoration:none">Students</a>
                    <i class="ti ti-chevron-right"></i>
                    <span>Edit</span>
                </div>
                <h1>Edit Student</h1>
                <p class="sub">Perbarui data mahasiswa yang sudah tersimpan.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="back"><i class="ti ti-arrow-left"></i> Dashboard</a>
                <a href="{{ route('students.index') }}" class="back"><i class="ti ti-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <strong>Edit Data Student</strong>
                <span>Pastikan NIM dan email tetap unik setelah perubahan.</span>
            </div>

            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid">
                    <div class="field">
                        <label for="student_id">Student ID</label>
                        <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}">
                        @error('student_id') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="year_entrance">Angkatan</label>
                        <input type="number" id="year_entrance" name="year_entrance" value="{{ old('year_entrance', $student->year_entrance) }}" min="1900" max="2100">
                        @error('year_entrance') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field full">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active" @selected(old('status', $student->status) === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $student->status) === 'inactive')>Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('students.index') }}" class="ghost">Batal</a>
                    <button type="submit" class="primary"><i class="ti ti-device-floppy"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>