@extends('layouts.app')

@section('title', 'Data Students')

@push('styles')
<style>
* { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background:
                radial-gradient(circle at top left, rgba(24, 95, 165, 0.14), transparent 28%),
                radial-gradient(circle at top right, rgba(250, 204, 21, 0.15), transparent 22%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            padding: 32px 20px 40px;
        }
        .wrap { max-width: 1180px; margin: 0 auto; }
        .hero {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-end;
            margin-bottom: 22px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        .crumb {
            display: inline-flex;
            gap: 6px;
            align-items: center;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 10px;
        }
        h1 { margin: 0; font-size: 30px; letter-spacing: -0.03em; }
        .sub { margin: 8px 0 0; color: #64748b; font-size: 14px; max-width: 620px; }
        .primary {
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
            background: #185FA5; color: #fff; border-radius: 12px; padding: 12px 16px;
            font-weight: 600; box-shadow: 0 14px 30px rgba(24, 95, 165, 0.18);
        }
        .primary:hover { background: #0c447c; }
        .stats {
            display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px;
            margin-bottom: 18px;
        }
        .stat {
            background: rgba(255,255,255,.78); backdrop-filter: blur(10px);
            border: 1px solid rgba(148, 163, 184, 0.18); border-radius: 18px; padding: 18px;
        }
        .stat .label { color: #64748b; font-size: 12px; margin-bottom: 8px; }
        .stat .value { font-size: 28px; font-weight: 700; line-height: 1; }
        .panel {
            background: rgba(255,255,255,.88); backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.18); border-radius: 20px;
            overflow: hidden; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }
        .toolbar {
            display: flex; justify-content: space-between; gap: 14px; align-items: center;
            padding: 16px 18px; border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }
        .search {
            display: flex; align-items: center; gap: 10px; background: #fff;
            border: 1px solid #dbe3ee; border-radius: 12px; padding: 10px 12px; min-width: 280px;
        }
        .search input {
            border: none; outline: none; font-size: 13px; width: 100%; background: transparent;
        }
        .count { color: #64748b; font-size: 13px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 980px; }
        thead th {
            text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .08em;
            color: #94a3b8; background: #f8fafc; padding: 14px 18px; border-bottom: 1px solid #e2e8f0;
        }
        tbody td { padding: 16px 18px; border-bottom: 1px solid #eef2f7; vertical-align: middle; }
        tbody tr:hover { background: #fbfdff; }
        .student-cell { display: flex; gap: 12px; align-items: center; }
        .avatar {
            width: 40px; height: 40px; border-radius: 14px; display: grid; place-items: center;
            background: linear-gradient(135deg, #185FA5, #5ea1e3); color: #fff; flex-shrink: 0;
        }
        .student-name { font-weight: 700; }
        .meta { color: #64748b; font-size: 12px; margin-top: 2px; }
        .badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px;
            font-size: 12px; font-weight: 700;
        }
        .badge.active { color: #166534; background: #dcfce7; }
        .badge.inactive { color: #9a3412; background: #ffedd5; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn, .btn-link, .btn-danger {
            display: inline-flex; align-items: center; gap: 6px; border-radius: 10px; padding: 9px 12px;
            font-size: 12px; text-decoration: none; border: 1px solid transparent; cursor: pointer;
            font-weight: 600;
        }
        .btn-link { background: #e6f1fb; color: #0c447c; }
        .btn-link:hover { background: #d8eaf8; }
        .btn { background: #f8fafc; border-color: #dbe3ee; color: #334155; }
        .btn:hover { background: #eef4fa; }
        .btn-danger { background: #fff1f2; color: #b91c1c; border-color: #fecdd3; }
        .btn-danger:hover { background: #ffe4e6; }
        .empty {
            text-align: center; padding: 72px 18px; color: #94a3b8;
        }
        .empty i { font-size: 42px; display: block; margin-bottom: 10px; }
        @media (max-width: 860px) {
            body { padding: 18px 14px 28px; }
            .hero { flex-direction: column; align-items: stretch; }
            .stats { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .search { min-width: 0; width: 100%; }
        }
</style>
@endpush

@section('content')

<div class="wrap">
        <div class="hero">
            <div>
                <div class="crumb">
                    <i class="ti ti-home"></i>
                    <span>Beranda</span>
                    <i class="ti ti-chevron-right"></i>
                    <span>Students</span>
                </div>
                <h1>Data Students</h1>
                <p class="sub">Kelola data mahasiswa dengan nomor induk, nama, email, angkatan, dan status aktif/inaktif.</p>
            </div>
            
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('students.print') }}" class="btn" style="background:#fff; border:1px solid #dbe3ee; color:#334155;">
                    <i class="ti ti-printer"></i> Cetak Student
                </a>
                <button type="button" onclick="document.getElementById('importModal').style.display='flex'" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; background: #fff; color: #185FA5; border-radius: 12px; padding: 12px 16px; font-weight: 600; border: 1px solid #dbe3ee; cursor: pointer; font-size: 14px;">
                        <i class="ti ti-upload"></i> Import CSV
                </button>
                <a href="{{ route('students.create') }}" class="primary">
                    <i class="ti ti-plus"></i> Tambah Student
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 500;">
                <i class="ti ti-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="stats">
            <div class="stat">
                <div class="label">Total data</div>
                <div class="value">{{ $students->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Student aktif</div>
                <div class="value">{{ $students->where('status', 'active')->count() }}</div>
            </div>
            <div class="stat">
                <div class="label">Student inaktif</div>
                <div class="value">{{ $students->where('status', 'inactive')->count() }}</div>
            </div>
        </div>

        <div class="panel">
            <div class="toolbar">
                <div class="count"><strong>{{ $students->count() }}</strong> records tersedia</div>
                <div class="search">
                    <i class="ti ti-search" style="color:#94a3b8"></i>
                    <input type="text" id="studentSearch" placeholder="Cari nama, NIM, email..." oninput="filterStudents()">
                </div>
            </div>

            <div class="table-wrap">
                @if($students->isEmpty())
                    <div class="empty">
                        <i class="ti ti-users-off"></i>
                        <div>Belum ada data student.</div>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th style="width:72px">No</th>
                                <th>Student</th>
                                <th style="width:150px">NIM</th>
                                <th>Email</th>
                                <th style="width:120px">Angkatan</th>
                                <th style="width:120px">Status</th>
                                <th style="width:190px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTable">
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="student-cell">
                                            <div class="avatar">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="student-name">{{ $student->name }}</div>
                                                <div class="meta">ID internal #{{ $student->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->year_entrance }}</td>
                                    <td>
                                        <span class="badge {{ $student->status === 'active' ? 'active' : 'inactive' }}">
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('students.show', $student->id) }}" class="btn">
                                                <i class="ti ti-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn-link">
                                                <i class="ti ti-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data student ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger">
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
    </div>

    <script>
        function filterStudents() {
            const query = document.getElementById('studentSearch').value.toLowerCase();
            document.querySelectorAll('#studentsTable tr').forEach((row) => {
                row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        }
    </script>

@endsedtion
    <div id="importModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: #fff; width: 100%; max-width: 420px; border-radius: 20px; padding: 28px; box-shadow: 0 24px 60px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0; color: #1f2937;">Import Mahasiswa</h3>
                <button type="button" onclick="document.getElementById('importModal').style.display='none'" style="border:none; background:#f1f5f9; border-radius:50%; width:32px; height:32px; cursor:pointer; color:#64748b; display:flex; align-items:center; justify-content:center;">&times;</button>
            </div>
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #475569;">Pilih File CSV (.csv)</label>
                    <input type="file" name="file" accept=".csv" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px;">
                </div>
                <button type="submit" class="primary" style="width: 100%; justify-content: center; font-size: 15px; padding: 14px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; background: #185FA5; color: #fff; border-radius: 12px; font-weight: 600; border: none; cursor: pointer;">
                    <i class="ti ti-upload"></i> Proses Import
                </button>
            </form>
        </div>
    </div>
</body>
</html>
