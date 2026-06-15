<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            padding: 32px 24px;
        }

        .wrap { max-width: 1100px; margin: 0 auto; }

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
            transition: background 0.2s;
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

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 0.5px solid #6ee7b7;
        }

        .table-wrap {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .table thead {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 500;
            color: #6b7280;
        }

        .table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-cell {
            display: flex;
            gap: 6px;
        }

        .btn-edit {
            padding: 6px 12px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            transition: background 0.2s;
        }
        .btn-edit:hover { background: #0284c7; }

        .btn-delete {
            padding: 6px 12px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }
        .btn-delete:hover { background: #dc2626; }

        .empty-state {
            padding: 60px 24px;
            text-align: center;
            background: #fff;
            border-radius: 12px;
            border: 0.5px solid #e5e7eb;
        }
        .empty-state p { color: #6b7280; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="crumb">
            <i class="ti ti-home" style="font-size: 12px;"></i>
            <span>Dashboard</span>
            <span style="margin: 0 4px;">/</span>
            <span>Mahasiswa</span>
        </div>

        <div class="page-head">
            <div>
                <h1>Daftar Mahasiswa</h1>
                <p>Kelola data mahasiswa sistem akademik</p>
            </div>
            <a href="{{ route('students.create') }}" class="btn-primary">
                <i class="ti ti-plus" style="font-size: 15px;"></i>
                Tambah Mahasiswa
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <strong>✓ Berhasil!</strong> {{ session('success') }}
        </div>
        @endif

        @if($students->isEmpty())
        <div class="empty-state">
            <i class="ti ti-inbox" style="font-size: 48px; color: #d1d5db;"></i>
            <p style="margin-top: 16px;">Belum ada data mahasiswa</p>
            <a href="{{ route('students.create') }}" class="btn-primary">Tambah Data Pertama</a>
        </div>
        @else
        <div class="toolbar">
            <div class="count-pill">
                <i class="ti ti-users" style="font-size: 14px;"></i>
                Total: <strong>{{ $students->count() }}</strong> mahasiswa
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tahun Masuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $student->student_id }}</strong></td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->year_entrance }}</td>
                        <td>
                            <span class="status-badge {{ $student->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $student->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn-edit">
                                    <i class="ti ti-edit" style="font-size: 12px;"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                                        <i class="ti ti-trash" style="font-size: 12px;"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>
</html>
