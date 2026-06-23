<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Skripsi — Sistem Skripsi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 900px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 9px 12px; border: 0.5px solid #d1d5db; border-radius: 8px;
            font-size: 13px; font-family: inherit; color: #1a1a2e; background: #fff; outline: none;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #185FA5; }
        .form-hint { font-size: 12px; color: #9ca3af; margin-top: 5px; display: block; }
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-primary:hover { background: #0C447C; }
        .btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: transparent; color: #1a1a2e; border: 0.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-secondary:hover { background: #f9fafb; }
        .course-row { display: flex; gap: 8px; align-items: center; margin-bottom: 8px; }
        .course-row select { flex: 2; }
        .course-row select.grade { flex: 1; }
        .btn-del { width: 34px; height: 34px; padding: 0; display: flex; align-items: center; justify-content: center; background: transparent; border: 0.5px solid #e5e7eb; border-radius: 6px; cursor: pointer; color: #A32D2D; flex-shrink: 0; }
        .btn-del:hover { background: #FCEBEB; border-color: #F09595; }
        @media (max-width: 600px) { body { padding: 16px; } }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <span>Beranda</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <a href="#" style="color:#9ca3af;text-decoration:none;">Dashboard</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Ajukan Skripsi</span>
                </div>
                <h1>Ajukan Skripsi</h1>
                <p>Isi form berikut untuk mengajukan skripsi</p>
            </div>
        </div>

        <form action="#" method="POST">

            <div class="card">
                <div class="card-title">Informasi Skripsi</div>

                <div class="form-group">
                    <label for="title">Judul Skripsi</label>
                    <input type="text" id="title" name="title" placeholder="Contoh: Sistem rekomendasi pembimbing berbasis kemiripan topik">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="4" placeholder="Jelaskan latar belakang dan tujuan skripsi secara singkat..."></textarea>
                </div>

                <div class="form-group">
                    <label for="suggestion_supervisor">Usulan Dosen Pembimbing</label>
                    <select id="suggestion_supervisor" name="suggestion_supervisor">
                        <option value="">Pilih dosen pembimbing</option>
                        <option value="1">Dr. Ardiansyah, S.T., M.Cs.</option>
                        <option value="2">Ali Tarmuji, S.T., M.Cs.</option>
                        <option value="3">Ir. Dinan Yulianto, S.T., M.Eng.</option>
                    </select>
                    <span class="form-hint">Ini hanya usulan. Keputusan akhir ada di tangan prodi.</span>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Riwayat Mata Kuliah Pilihan</div>

                <div id="courses-wrap">
                    <div class="course-row">
                        <select name="courses[0][name]">
                            <option value="">Pilih mata kuliah</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Basis Data Lanjut">Basis Data Lanjut</option>
                            <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
                            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                        </select>
                        <select name="courses[0][grade]" class="grade">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                        <button type="button" class="btn-del" onclick="removeRow(this)"><i class="ti ti-x" style="font-size:14px"></i></button>
                    </div>
                </div>

                <button type="button" class="btn-secondary" style="margin-top:4px;font-size:13px;padding:7px 14px;" onclick="addRow()">
                    <i class="ti ti-plus" style="font-size:14px"></i> Tambah mata kuliah
                </button>
            </div>

            <div style="display:flex;gap:8px;">
                <a href="/mahasiswa/dashboard" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="ti ti-send"></i> Ajukan Skripsi
                </button>
            </div>
        </form>
    </div>

    <script>
        let rowCount = 1;
        const courses = ['Pemrograman Web', 'Basis Data Lanjut', 'Kecerdasan Buatan', 'Rekayasa Perangkat Lunak', 'Jaringan Komputer'];

        function addRow() {
            const wrap = document.getElementById('courses-wrap');
            const div = document.createElement('div');
            div.className = 'course-row';
            div.innerHTML = `
                <select name="courses[${rowCount}][name]">
                    <option value="">Pilih mata kuliah</option>
                    ${courses.map(c => `<option value="${c}">${c}</option>`).join('')}
                </select>
                <select name="courses[${rowCount}][grade]" class="grade">
                    <option>A</option><option>B</option><option>C</option><option>D</option><option>E</option>
                </select>
                <button type="button" class="btn-del" onclick="removeRow(this)"><i class="ti ti-x" style="font-size:14px"></i></button>
            `;
            wrap.appendChild(div);
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.course-row');
            if (rows.length > 1) btn.closest('.course-row').remove();
        }
    </script>
</body>
</html>