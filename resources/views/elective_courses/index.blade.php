<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah Pilihan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 900px; margin: 0 auto; }

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

        .btn-primary {
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
            text-decoration: none;
        }
        .btn-primary:hover { background: #0C447C; }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .count-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 20px;
            font-size: 12px;
            color: #6b7280;
        }
        .count-pill strong { color: #1a1a2e; font-weight: 500; }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
        }
        .search-box i { font-size: 15px; color: #9ca3af; }
        .search-box input {
            border: none;
            background: transparent;
            font-size: 13px;
            color: #1a1a2e;
            outline: none;
            width: 200px;
        }

        .table-wrap {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }

        thead { background: #f9fafb; }
        thead th {
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 0.5px solid #e5e7eb;
            text-align: left;
        }

        tbody tr { border-bottom: 0.5px solid #f0f0f0; transition: background .1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f9fafb; }
        tbody td { padding: 13px 16px; vertical-align: middle; }

        .no-col { color: #9ca3af; font-size: 12px; }
        .date-col { font-size: 12px; color: #6b7280; }

        .name-cell { display: flex; align-items: center; gap: 10px; }
        .icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #E6F1FB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .icon-wrap i { font-size: 16px; color: #0C447C; }
        .course-name { font-size: 13px; color: #1a1a2e; font-weight: 500; }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 6px;
            font-size: 12px;
            color: #A32D2D;
            cursor: pointer;
        }
        .btn-del:hover { background: #FCEBEB; border-color: #F09595; }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: transparent;
            border: 0.5px solid #e5e7eb;
            border-radius: 6px;
            font-size: 12px;
            color: #185FA5;
            text-decoration: none;
        }
        .btn-edit:hover { background: #E6F1FB; border-color: #85B7EB; }
        .action-wrap { display: flex; gap: 6px; }

        .empty {
            text-align: center;
            padding: 56px 16px;
            color: #9ca3af;
        }
        .empty i { font-size: 36px; display: block; margin-bottom: 10px; opacity: .4; }
        .empty p { font-size: 14px; }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .search-box { display: none; }
        }
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
                    <span>Mata Kuliah Pilihan</span>
                </div>
                <h1>Mata Kuliah Pilihan</h1>
                <p>Daftar mata kuliah pilihan yang tersedia</p>
            </div>
            <a href="{{ route('elective-courses.create') }}" class="btn-primary">
                <i class="ti ti-plus"></i> Tambah Mata Kuliah
            </a>
        </div>

        <div class="toolbar">
            <div class="count-pill">
                <i class="ti ti-books" style="font-size:13px"></i>
                <strong>{{ $courses->count() }}</strong> mata kuliah tersedia
            </div>
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" id="q" placeholder="Cari nama mata kuliah..." oninput="filterTable()">
            </div>
        </div>

        <div class="table-wrap">
            @if($courses->isEmpty())
                <div class="empty">
                    <i class="ti ti-book-off"></i>
                    <p>Belum ada data mata kuliah pilihan.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th style="width:48px">No</th>
                            <th>Mata Kuliah</th>
                            <th style="width:160px">Ditambahkan</th>
                            <th style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach($courses as $index => $course)
                            <tr>
                                <td class="no-col">{{ $index + 1 }}</td>
                                <td>
                                    <div class="name-cell">
                                        <div class="icon-wrap">
                                            <i class="ti ti-book"></i>
                                        </div>
                                        <span class="course-name">{{ $course->courses }}</span>
                                    </div>
                                </td>
                                <td class="date-col">{{ \Carbon\Carbon::parse($course->timestamp)->format('d M Y') }}</td>
                                <td>
                                    <div class="action-wrap">
                                         <a href="{{ route('elective-courses.show', $course->id) }}" class="btn-edit">
                                            <i class="ti ti-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('elective-courses.edit', $course->id) }}" class="btn-edit">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('elective-courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-del">
                                                <i class="ti ti-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('q').value.toLowerCase();
            document.querySelectorAll('#tbody tr').forEach(r => {
                r.style.display = r.querySelector('.course-name').textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    </script>
</body>
</html>