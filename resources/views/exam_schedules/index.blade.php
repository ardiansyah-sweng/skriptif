<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Sidang Skripsi - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
        .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; }
        .meta-text { font-size: 12px; color: #64748b; }
        .badge-proposal { background: #eff6ff; color: #1d4ed8; }
        .badge-hasil { background: #fef3c7; color: #d97706; }
        .badge-pendadaran { background: #dcfce7; color: #15803d; }
        .status-terjadwal { background-color: #eff6ff; color: #1d4ed8; }
        .status-selesai { background-color: #dcfce7; color: #15803d; }
        .status-dibatalkan { background-color: #fee2e2; color: #b91c1c; }
        .btn-add { background-color: #2563eb; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 8px 18px; border: none; text-decoration: none; }
        .btn-add:hover { background-color: #1d4ed8; color: white; }
        .btn-delete { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
        .btn-delete:hover { background-color: #dc2626; color: white; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="main-title">Jadwal Sidang Skripsi</h1>
                <p class="sub-title">Kelola penjadwalan sidang proposal dan pendadaran.</p>
            </div>
            <a href="{{ route('exam-schedules.create') }}" class="btn-add">
                <i class="fa-solid fa-plus me-1"></i> Tambah Jadwal
            </a>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <span class="fw-bold text-dark">Daftar Jadwal Sidang</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 4%">No</th>
                            <th style="width: 16%">Mahasiswa / NIM</th>
                            <th style="width: 24%">Judul Skripsi</th>
                            <th style="width: 12%" class="text-center">Jenis Sidang</th>
                            <th style="width: 16%">Tanggal & Waktu</th>
                            <th style="width: 10%">Ruang</th>
                            <th style="width: 10%" class="text-center">Status</th>
                            <th style="width: 8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $key => $schedule)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $schedule->skripsi->student->name ?? '-' }}</div>
                                <div class="meta-text">NIM. {{ $schedule->skripsi->student->student_id ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $schedule->skripsi->title ?? '-' }}</div>
                                @if($schedule->skripsi->supervisor)
                                    <div class="meta-text mt-1 text-primary">
                                        <i class="fa-solid fa-user-tie me-1"></i> {{ $schedule->skripsi->supervisor->name }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($schedule->jenis_sidang === 'proposal')
                                    <span class="badge-status badge-proposal"><i class="fa-solid fa-file-lines"></i> Proposal</span>
                                @else
                                    <span class="badge-status badge-pendadaran"><i class="fa-solid fa-graduation-cap"></i> Pendadaran</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ $schedule->tanggal_sidang->format('d M Y') }}</div>
                                <div class="meta-text">{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</div>
                            </td>
                            <td>{{ $schedule->ruang }}</td>
                            <td class="text-center">
                                @if($schedule->status === 'terjadwal')
                                    <span class="badge-status status-terjadwal"><i class="fa-solid fa-calendar-check"></i> Terjadwal</span>
                                @elseif($schedule->status === 'selesai')
                                    <span class="badge-status status-selesai"><i class="fa-solid fa-check"></i> Selesai</span>
                                @else
                                    <span class="badge-status status-dibatalkan"><i class="fa-solid fa-xmark"></i> Dibatalkan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('exam-schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal sidang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px;"></i>
                                Belum ada jadwal sidang.
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
