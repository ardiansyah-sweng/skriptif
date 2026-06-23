
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Book Bimbingan - Skriptif</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; display: flex; justify-content: space-between; align-items: center; }
        .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
        .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; text-transform: capitalize; }
        .status-pending  { background-color: #fef3c7; color: #d97706; }
        .status-approved { background-color: #dcfce7; color: #15803d; }
        .status-rejected { background-color: #fee2e2; color: #b91c1c; }
        .btn-add { background-color: #1e293b; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 8px 16px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background-color 0.2s; }
        .btn-add:hover { background-color: #0f172a; color: white; }
        .btn-edit { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .btn-edit:hover { background-color: #dbeafe; color: #1e40af; }
        .btn-delete { background-color: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 4px; }
        .btn-delete:hover { background-color: #ffe4e6; color: #9f1239; }
        .meta-text { font-size: 12px; color: #64748b; }
        .crumb { font-size: 12px; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .crumb a { color: #64748b; text-decoration: none; }
        .crumb a:hover { color: #0f172a; }
        .search-input { border-radius: 8px 0 0 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 8px 16px; }
        .search-input:focus { box-shadow: none; border-color: #94a3b8; }
        .filter-select { border-radius: 0; border: 1px solid #cbd5e1; border-left: none; font-size: 14px; color: #64748b; width: 150px; }
        .filter-select:focus { box-shadow: none; border-color: #94a3b8; }
        .search-btn { border-radius: 0 8px 8px 0; border: 1px solid #cbd5e1; border-left: none; background: #f1f5f9; color: #334155; font-size: 14px; padding: 8px 16px; }
        .search-btn:hover { background: #e2e8f0; }
        .reset-btn { border-radius: 8px; font-size: 14px; padding: 8px 16px; text-decoration: none; display: inline-flex; align-items: center; background: transparent; color: #64748b; border: 1px solid #e2e8f0; margin-left: 8px; }
        .reset-btn:hover { background: #f8fafc; color: #334155; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" style="background-color: #dcfce7; color: #15803d; border-radius: 8px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="crumb">
            <i class="fa-solid fa-house"></i>
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px;"></i>
            <span class="fw-semibold" style="color: #0f172a;">Log Book Bimbingan</span>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="main-title">Log Book Bimbingan Mahasiswa</h1>
                <p class="sub-title">Daftar rekapan konsultasi bimbingan tugas akhir / skripsi mahasiswa dengan dosen pembimbing.</p>
            </div>
            <a href="{{ route('log-books.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Log Book
            </a>
        </div>
        <!-- Filter & Search Bar -->
        <div class="mb-4">
            <form action="{{ route('log-books.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group" style="max-width: 600px;">
                    <input type="text" name="q" class="form-control search-input" placeholder="Cari nama/NIM mahasiswa, dosen, atau aktivitas..." value="{{ request('q') }}">
                    <select name="status" class="form-select filter-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button class="btn search-btn" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                </div>
                @if(request('q') || request('status'))
                    <a href="{{ route('log-books.index') }}" class="reset-btn">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> Reset
                    </a>
                @endif
            </form>
        </div>
        <!-- Content Table Card -->
        <div class="content-card">
            <div class="card-header-custom">
                <span class="fw-bold text-dark"><i class="fa-solid fa-list-check me-2 text-secondary"></i>Daftar Catatan Bimbingan</span>
                <span class="badge bg-light text-dark border meta-text fw-semibold">{{ $logBooks->count() }} Entri ditemukan</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Mahasiswa</th>
                            <th style="width: 20%">Dosen Pembimbing</th>
                            <th style="width: 12%">Tanggal</th>
                            <th style="width: 28%">Aktivitas & Catatan Feedback</th>
                            <th style="width: 15%" class="text-center">Status</th>
                            <th style="width: 10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logBooks as $key => $log)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $log->student->name ?? '-' }}</div>
                                <div class="meta-text">NIM. {{ $log->student->student_id ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $log->lecturer->name ?? '-' }}</div>
                                <div class="meta-text"><i class="fa-solid fa-envelope me-1"></i>{{ $log->lecturer->email ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $log->date ? $log->date->format('d M Y') : '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark" style="white-space: pre-line;">{{ Str::limit($log->activity, 150) }}</div>
                                @if($log->feedback)
                                    <div class="mt-2 p-2 rounded bg-light border-start border-primary" style="font-size: 13px;">
                                        <span class="fw-bold text-primary d-block" style="font-size: 11px;"><i class="fa-solid fa-comment-dots me-1"></i>Feedback Dosen:</span>
                                        <span class="text-secondary italic">{{ Str::limit($log->feedback, 120) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($log->status == 'pending')
                                    <span class="badge-status status-pending">
                                        <i class="fa-solid fa-spinner fa-spin"></i> Pending
                                    </span>
                                @elseif($log->status == 'approved')
                                    <span class="badge-status status-approved">
                                        <i class="fa-solid fa-circle-check"></i> Approved
                                    </span>
                                @else
                                    <span class="badge-status status-rejected">
                                        <i class="fa-solid fa-circle-xmark"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('log-books.edit', $log->id) }}" class="btn-edit" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('log-books.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan bimbingan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus Data">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fa-regular fa-folder-open d-block mb-3 text-secondary" style="font-size: 40px; opacity: 0.5;"></i>
                                    <h5 class="fw-semibold text-dark mb-1">Belum Ada Data Log Book</h5>
                                    <p class="text-muted small">Catatan konsultasi bimbingan mahasiswa tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
