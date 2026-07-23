<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Evaluasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 720px; margin: 0 auto; }

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
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
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

        /* Role tabs (Pembimbing / Penguji) */
        .role-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }
        .role-tab {
            flex: 1;
            text-align: center;
            padding: 10px 12px;
            border: 0.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            background: #fff;
        }
        .role-tab.active {
            border-color: #185FA5;
            background: #E6F1FB;
            color: #0C447C;
        }
        .role-tab input { display: none; }

        /* Dosen list per peran, disembunyikan/ditampilkan sesuai role aktif */
        .role-panel { display: none; }
        .role-panel.active { display: block; }

        .component-row {
            display: grid;
            grid-template-columns: 1fr 90px 90px;
            gap: 10px;
            align-items: start;
            padding: 10px 0;
            border-bottom: 0.5px solid #f0f0f0;
        }
        .component-row:last-child { border-bottom: none; }
        .component-row .comp-name {
            font-size: 12.5px;
            color: #374151;
            line-height: 1.4;
        }
        .component-row .comp-range {
            font-size: 11px;
            color: #9ca3af;
            align-self: center;
        }
        .component-row input {
            width: 100%;
            padding: 7px 10px;
            border: 0.5px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            margin-top: 4px;
            border-top: 0.5px solid #e5e7eb;
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
        }
        .total-row .total-value { font-size: 16px; color: #185FA5; }
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
                <span>Tambah</span>
            </div>
            <h1>Tambah Evaluasi</h1>
            <p>Isi hasil penilaian per unsur untuk Dosen Pembimbing atau Dosen Penguji</p>
        </div>

        <form action="{{ route('evaluations.store') }}" method="POST" id="evaluationForm">
            @csrf

            <div class="card">
                <div class="card-title"><i class="ti ti-file-description"></i> Data Skripsi &amp; Tanggal</div>

                <div class="field">
                    <label for="skripsi_id">Skripsi</label>
                    <select name="skripsi_id" id="skripsi_id" required>
                        <option value="">-- Pilih skripsi --</option>
                        @foreach($skripsiList as $skripsi)
                            <option value="{{ $skripsi->id }}" {{ old('skripsi_id') == $skripsi->id ? 'selected' : '' }}>
                                {{ $skripsi->student->name ?? '-' }} — {{ $skripsi->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('skripsi_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="evaluation_date">Tanggal Evaluasi</label>
                    <input type="date" name="evaluation_date" id="evaluation_date" value="{{ old('evaluation_date') }}" required>
                    @error('evaluation_date') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="field" style="margin-bottom:0">
                    <label for="weight">Bobot Peran (%)</label>
                    <input type="number" name="weight" id="weight" min="0" max="100" step="0.01" value="{{ old('weight', 50) }}">
                    <div class="hint">Default 50%, sesuai rekap Pembimbing 50% + Penguji 50% = Total Nilai Sempro.</div>
                    @error('weight') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-title"><i class="ti ti-users"></i> Peran Penilai &amp; Dosen</div>

                <div class="role-tabs">
                    <label class="role-tab {{ old('role', 'pembimbing') == 'pembimbing' ? 'active' : '' }}" data-role-tab="pembimbing">
                        <input type="radio" name="role" value="pembimbing" {{ old('role', 'pembimbing') == 'pembimbing' ? 'checked' : '' }}>
                        Dosen Pembimbing
                    </label>
                    <label class="role-tab {{ old('role') == 'penguji' ? 'active' : '' }}" data-role-tab="penguji">
                        <input type="radio" name="role" value="penguji" {{ old('role') == 'penguji' ? 'checked' : '' }}>
                        Dosen Penguji
                    </label>
                </div>
                @error('role') <div class="error-text" style="margin-bottom:12px">{{ $message }}</div> @enderror

                {{-- List Dosen Pembimbing --}}
                <div class="role-panel {{ old('role', 'pembimbing') == 'pembimbing' ? 'active' : '' }}" data-role-panel="pembimbing">
                    <div class="field" style="margin-bottom:0">
                        <label for="lecturer_id_pembimbing">Dosen Pembimbing</label>
                        <select id="lecturer_id_pembimbing" class="lecturer-select" data-role="pembimbing">
                            <option value="">-- Pilih dosen pembimbing --</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id && old('role', 'pembimbing') == 'pembimbing' ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- List Dosen Penguji --}}
                <div class="role-panel {{ old('role') == 'penguji' ? 'active' : '' }}" data-role-panel="penguji">
                    <div class="field" style="margin-bottom:0">
                        <label for="lecturer_id_penguji">Dosen Penguji</label>
                        <select id="lecturer_id_penguji" class="lecturer-select" data-role="penguji">
                            <option value="">-- Pilih dosen penguji --</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id && old('role') == 'penguji' ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Hidden field terkirim ke server, diisi otomatis dari dropdown yang aktif --}}
                <input type="hidden" name="lecturer_id" id="lecturer_id" value="{{ old('lecturer_id') }}">
                @error('lecturer_id') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="card">
                <div class="card-title"><i class="ti ti-clipboard-list"></i> Komponen Penilaian</div>

                {{-- Rubrik Pembimbing --}}
                <div class="role-panel {{ old('role', 'pembimbing') == 'pembimbing' ? 'active' : '' }}" data-role-panel="pembimbing">
                    @foreach($components['pembimbing'] as $component)
                        <div class="component-row">
                            <div class="comp-name">{{ $loop->iteration }}. {{ $component->name }}</div>
                            <div class="comp-range">{{ rtrim(rtrim($component->min_score, '0'), '.') }} - {{ rtrim(rtrim($component->max_score, '0'), '.') }}</div>
                            <input
                                type="number"
                                class="component-input"
                                data-role="pembimbing"
                                name="components[{{ $component->id }}]"
                                min="{{ $component->min_score }}"
                                max="{{ $component->max_score }}"
                                step="0.01"
                                value="{{ old('components.' . $component->id) }}"
                            >
                        </div>
                        @error('components.' . $component->id) <div class="error-text">{{ $message }}</div> @enderror
                    @endforeach
                </div>

                {{-- Rubrik Penguji --}}
                <div class="role-panel {{ old('role') == 'penguji' ? 'active' : '' }}" data-role-panel="penguji">
                    @foreach($components['penguji'] as $component)
                        <div class="component-row">
                            <div class="comp-name">{{ $loop->iteration }}. {{ $component->name }}</div>
                            <div class="comp-range">{{ rtrim(rtrim($component->min_score, '0'), '.') }} - {{ rtrim(rtrim($component->max_score, '0'), '.') }}</div>
                            <input
                                type="number"
                                class="component-input"
                                data-role="penguji"
                                name="components[{{ $component->id }}]"
                                min="{{ $component->min_score }}"
                                max="{{ $component->max_score }}"
                                step="0.01"
                                value="{{ old('components.' . $component->id) }}"
                            >
                        </div>
                        @error('components.' . $component->id) <div class="error-text">{{ $message }}</div> @enderror
                    @endforeach
                </div>

                <div class="total-row">
                    <span>Total Nilai</span>
                    <span class="total-value" id="totalDisplay">0</span>
                </div>
                <div class="hint">Nilai otomatis dikonversi ke huruf: A (≥85), B (≥70), C (≥55), D (≥40), E (&lt;40)</div>
            </div>

            <div class="card">
                <div class="card-title"><i class="ti ti-note"></i> Catatan</div>
                <div class="field" style="margin-bottom:0">
                    <textarea name="notes" id="notes" placeholder="Feedback atau catatan tambahan dari dosen">{{ old('notes') }}</textarea>
                    @error('notes') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn-primary">Simpan Evaluasi</button>
                <a href="{{ route('evaluations.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const roleTabs = document.querySelectorAll('.role-tab');
        const rolePanels = document.querySelectorAll('.role-panel');
        const lecturerHidden = document.getElementById('lecturer_id');
        const totalDisplay = document.getElementById('totalDisplay');

        function setActiveRole(role) {
            roleTabs.forEach(tab => tab.classList.toggle('active', tab.dataset.roleTab === role));
            rolePanels.forEach(panel => panel.classList.toggle('active', panel.dataset.rolePanel === role));

                document.querySelectorAll('.component-input').forEach(input => {
                input.disabled = input.dataset.role !== role;
                 });

            const lecturerSelect = document.querySelector(`.lecturer-select[data-role="${role}"]`);
            lecturerHidden.value = lecturerSelect ? lecturerSelect.value : '';
            

            updateTotal();
            
        }

        function updateTotal() {
            const activeRole = document.querySelector('.role-tab.active')?.dataset.roleTab;
            let total = 0;
            document.querySelectorAll(`.component-input[data-role="${activeRole}"]`).forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalDisplay.textContent = total.toFixed(2).replace(/\.00$/, '');
        }

        roleTabs.forEach(tab => {
            tab.addEventListener('click', () => setActiveRole(tab.dataset.roleTab));
        });

        document.querySelectorAll('.lecturer-select').forEach(select => {
            select.addEventListener('change', () => {
                lecturerHidden.value = select.value;
            });
        });

        document.querySelectorAll('.component-input').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Inisialisasi tampilan sesuai role terpilih (mendukung old() saat validasi gagal)
        const initialRole = document.querySelector('input[name="role"]:checked')?.value || 'pembimbing';
        setActiveRole(initialRole);

        // FIX: browser dengan locale Indonesia menampilkan angka desimal pakai koma
        // (mis. "49,99"), padahal Laravel butuh titik ("49.99"). Kalau tidak dinormalisasi,
        // browser bisa diam-diam menolak submit form tanpa pesan error apa pun.
        document.getElementById('evaluationForm').addEventListener('submit', function () {
            document.querySelectorAll('input[type="number"]').forEach(input => {
                if (typeof input.value === 'string' && input.value.includes(',')) {
                    input.value = input.value.replace(',', '.');
                }
            });
        });
    </script>
</body>
</html>