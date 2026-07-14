<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Evaluasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 640px; margin: 0 auto; }

        .crumb {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-head { margin-bottom: 1.5rem; }
        .page-head h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }

        .card {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }

        .field { margin-bottom: 16px; }
        .field label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .field select,
        .field input,
        .field textarea {
            width: 100%;
            padding: 9px 12px;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            color: #1a1a2e;
            outline: none;
            font-family: inherit;
        }
        .field select:focus,
        .field input:focus,
        .field textarea:focus { border-color: #185FA5; }

        .field textarea { resize: vertical; min-height: 70px; }

        .error-text {
            color: #A32D2D;
            font-size: 11px;
            margin-top: 4px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-primary {
            padding: 9px 18px;
            background: #185FA5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary:hover { background: #0C447C; }

        .btn-cancel {
            padding: 9px 18px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
        }
        .btn-cancel:hover { background: #f4f6f9; }

        .hint {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="page-head">
            <div class="crumb">
                <i class="ti ti-home" style="font-size:11px"></i>
                <span>Beranda</span>
                <i class="ti ti-chevron-right" style="font-size:11px"></i>
                <a href="{{ route('evaluations.index') }}" style="color:#9ca3af;text-decoration:none">Evaluasi Skripsi</a>
                <i class="ti ti-chevron-right" style="font-size:11px"></i>
                <span>Edit</span>
            </div>
            <h1>Edit Evaluasi</h1>
            <p>Perbarui hasil penilaian dosen penguji</p>
        </div>

        <div class="card">
            <form action="{{ route('evaluations.update', $evaluation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="skripsi_id">Skripsi</label>
                    <select name="skripsi_id" id="skripsi_id" required>
                        <option value="">-- Pilih skripsi --</option>
                        @foreach($skripsiList as $skripsi)
                            <option value="{{ $skripsi->id }}" {{ old('skripsi_id', $evaluation->skripsi_id) == $skripsi->id ? 'selected' : '' }}>
                                {{ $skripsi->student->name ?? '-' }} — {{ $skripsi->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('skripsi_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="lecturer_id">Dosen Penguji</label>
                    <select name="lecturer_id" id="lecturer_id" required>
                        <option value="">-- Pilih dosen penguji --</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id', $evaluation->lecturer_id) == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lecturer_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="score">Nilai (0-100)</label>
                    <input type="number" name="score" id="score" min="0" max="100" step="0.01" value="{{ old('score', $evaluation->score) }}" required>
                    <div class="hint">Nilai otomatis dikonversi ke huruf: A (≥85), B (≥70), C (≥55), D (≥40), E (&lt;40)</div>
                    @error('score') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="evaluation_date">Tanggal Evaluasi</label>
                    <input type="date" name="evaluation_date" id="evaluation_date" value="{{ old('evaluation_date', \Carbon\Carbon::parse($evaluation->evaluation_date)->format('Y-m-d')) }}" required>
                    @error('evaluation_date') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="notes">Catatan (opsional)</label>
                    <textarea name="notes" id="notes" placeholder="Feedback atau catatan tambahan dari dosen penguji">{{ old('notes', $evaluation->notes) }}</textarea>
                    @error('notes') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('evaluations.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>