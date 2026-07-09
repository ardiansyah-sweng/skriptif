<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal Sidang - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .meta-text { font-size: 12px; color: #64748b; }
        .detail-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .detail-value { font-size: 15px; font-weight: 600; color: #0f172a; word-break: break-word; }
        .detail-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; background: #ffffff; height: 100%; }
        .btn-back { font-size: 14px; color: #2563eb; text-decoration: none; font-weight: 500; }
        .btn-back:hover { color: #1d4ed8; text-decoration: underline; }
        .btn-submit { background-color: #2563eb; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 9px 18px; border: none; }
        .btn-submit:hover { background-color: #1d4ed8; color: white; }
        .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .badge-proposal { background: #eff6ff; color: #1d4ed8; }
        .badge-pendadaran { background: #dcfce7; color: #15803d; }
        .status-terjadwal { background-color: #eff6ff; color: #1d4ed8; }
        .status-selesai { background-color: #dcfce7; color: #15803d; }
        .status-dibatalkan { background-color: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 960px;">
        <div class="mb-4">
            <a href="{{ route('exam-schedules.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Jadwal
            </a>
        </div>

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

        <div class="mb-4">
            <h1 class="main-title">Detail Jadwal Sidang</h1>
            <p class="sub-title">Lihat informasi jadwal dan perbarui status pelaksanaan sidang.</p>
        </div>

        <div class="content-card mb-4">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark">Informasi Sidang</span>
                @if($schedule->jenis_sidang === 'proposal')
                    <span class="badge-status badge-proposal"><i class="fa-solid fa-file-lines"></i> Proposal</span>
                @else
                    <span class="badge-status badge-pendadaran"><i class="fa-solid fa-graduation-cap"></i> Pendadaran</span>
                @endif
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="detail-label">Mahasiswa</div>
                            <div class="detail-value">{{ $schedule->skripsi->student->name ?? '-' }}</div>
                            <div class="meta-text mt-1">NIM. {{ $schedule->skripsi->student->student_id ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="detail-label">Dosen Pembimbing</div>
                            <div class="detail-value">{{ $schedule->skripsi->supervisor->name ?? '-' }}</div>
                            <div class="meta-text mt-1">{{ $schedule->skripsi->supervisor->email ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-box">
                            <div class="detail-label">Judul Skripsi</div>
                            <div class="detail-value">{{ $schedule->skripsi->title ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-box">
                            <div class="detail-label">Tanggal Sidang</div>
                            <div class="detail-value">{{ $schedule->tanggal_sidang->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-box">
                            <div class="detail-label">Waktu</div>
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-box">
                            <div class="detail-label">Ruang</div>
                            <div class="detail-value">{{ $schedule->ruang }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-box">
                            <div class="detail-label">Catatan</div>
                            <div class="detail-value">{{ $schedule->catatan ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <span class="fw-bold text-dark">Status Jadwal</span>
            </div>
            <div class="p-4">
                <div class="mb-3">
                    @if($schedule->status === 'terjadwal')
                        <span class="badge-status status-terjadwal"><i class="fa-solid fa-calendar-check"></i> Terjadwal</span>
                    @elseif($schedule->status === 'selesai')
                        <span class="badge-status status-selesai"><i class="fa-solid fa-check"></i> Selesai</span>
                    @else
                        <span class="badge-status status-dibatalkan"><i class="fa-solid fa-xmark"></i> Dibatalkan</span>
                    @endif
                </div>

                <form action="{{ route('exam-schedules.update-status', $schedule->id) }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    @method('PATCH')
                    <div class="col-md-8">
                        <label for="status" class="form-label small fw-bold text-secondary">
                            Ubah Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="terjadwal" {{ old('status', $schedule->status) === 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="selesai" {{ old('status', $schedule->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status', $schedule->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-submit w-100">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
