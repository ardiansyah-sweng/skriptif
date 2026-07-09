<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Analitik Skripsi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .stat-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); transition: .3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        .stat-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .stat-value { font-size: 32px; font-weight: 700; line-height: 1.2; }
        .stat-label { font-size: 14px; color: #64748b; font-weight: 500; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; }
        .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
        .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .meta-text { font-size: 12px; color: #64748b; }
        .badge-bimbingan { background-color: #e0f2fe; color: #0284c7; font-size: 13px; font-weight: 600; padding: 4px 12px; border-radius: 20px; }
        .badge-sidang { background-color: #dcfce7; color: #16a34a; font-size: 13px; font-weight: 600; padding: 4px 12px; border-radius: 20px; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">

        <div class="mb-5">
            <h1 class="main-title">Statistik & Analitik Skripsi</h1>
            <p class="sub-title">Gambaran umum data skripsi dan bimbingan di program studi.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card p-4 d-flex align-items-center gap-4">
                    <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalMahasiswa }}</div>
                        <div class="stat-label">Total Mahasiswa</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4 d-flex align-items-center gap-4">
                    <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $skripsiAktif }}</div>
                        <div class="stat-label">Skripsi Aktif</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4 d-flex align-items-center gap-4">
                    <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $sudahSidang }}</div>
                        <div class="stat-label">Sudah Sidang</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold text-dark">Statistik Dosen Pembimbing</span>
                </div>
                <span class="meta-text"><i class="fa-solid fa-chalkboard-user me-1"></i> {{ $dosen->count() }} dosen</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 18%">NIP</th>
                            <th style="width: 25%">Nama Dosen</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 15%" class="text-center">Jumlah Bimbingan</th>
                            <th style="width: 12%" class="text-center">Sudah Sidang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosen as $index => $d)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="fw-medium">{{ $d->lecturer_id }}</span></td>
                            <td>
                                <span class="fw-semibold">{{ $d->name }}</span>
                            </td>
                            <td>
                                <span class="meta-text">{{ $d->email }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-bimbingan">{{ $d->total_bimbingan }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-sidang">{{ $d->sudah_sidang }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px;"></i>
                                Tidak ada data dosen.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
