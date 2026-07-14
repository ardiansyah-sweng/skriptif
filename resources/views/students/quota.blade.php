<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuota Pembimbing Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background: #f8fafc; }
        .card { border: none; border-radius: 15px; box-shadow: 0 3px 10px rgba(0,0,0,.08); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-5">
        <h2 class="fw-bold">Status Ketersediaan Kuota Dosen</h2>
        <p class="text-muted">Gunakan informasi kuota ini sebagai acuan sebelum Anda mengajukan judul skripsi.</p>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white fw-bold py-3">
            <i class="fa-solid fa-users me-2"></i> Daftar Kuota Bimbingan Dosen
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                @foreach($quotaStats as $stat)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0 text-dark text-truncate" style="max-width: 200px;">
                                    {{ $stat['name'] }}
                                </h6>
                                <span class="badge bg-dark">{{ $stat['current'] }} / {{ $stat['max'] }} Mahasiswa</span>
                            </div>
                            
                            <div class="progress mb-2" style="height: 10px; border-radius: 5px;">
                                <div class="progress-bar {{ $stat['color'] }} progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $stat['persentase'] }}%;">
                                </div>
                            </div>
                            
                            <small class="text-muted">
                                @if($stat['current'] >= $stat['max'])
                                    <span class="text-danger fw-bold"><i class="fa-solid fa-circle-xmark"></i> Kuota Penuh</span>
                                @else
                                    <span class="text-success fw-bold"><i class="fa-solid fa-circle-check"></i> Tersedia Slot</span>
                                @endif
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

</body>
</html>