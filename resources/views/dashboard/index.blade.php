<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            background:#f8fafc;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 3px 10px rgba(0,0,0,.08);
        }

        .stat-card{
            transition:.3s;
        }

        .stat-card:hover{
            transform:translateY(-5px);
        }

        .profile-icon{
            width:80px;
            height:80px;
            background:#0d6efd;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:50%;
            font-size:35px;
            margin:auto;
        }

        .badge{
            font-size:14px;
        }

    </style>

</head>
<body>

<div class="container py-5">

    <div class="mb-5">

        <h2 class="fw-bold">
            Dashboard Mahasiswa
        </h2>

        <p class="text-muted">
            Selamat datang kembali di Sistem Informasi Skripsi.
        </p>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body">

                    <h6>Status Skripsi</h6>

                    @if($skripsi)

                        <span class="badge bg-warning">
                            {{ ucfirst($skripsi->status) }}
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Belum Mengajukan
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body">

                    <h6>Angkatan</h6>

                    <h4>{{ $student->year_entrance ?? '-' }}</h4>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body">

                    <h6>Dosen Pembimbing</h6>

                    <h5>{{ $skripsi->supervisor->name ?? '-' }}</h5>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">

            <div class="card mb-4">

                <div class="card-body text-center">

                    <div class="profile-icon">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <h4 class="mt-3">

                        {{ $student->name ?? '-' }}

                    </h4>

                    <p class="text-muted">

                        {{ $student->student_id ?? '-' }}

                    </p>

                    <hr>

                    <p>

                        <strong>Email</strong>

                        <br>

                        {{ $student->email ?? '-' }}

                    </p>

                    <p>

                        <strong>Status</strong>

                        <br>

                        {{ ucfirst($student->status ?? '-') }}

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header bg-primary text-white">

                    Informasi Skripsi

                </div>

                <div class="card-body">

                    @if($skripsi)

                        <table class="table">

                            <tr>
                                <th width="200">Judul</th>
                                <td>{{ $skripsi->title }}</td>
                            </tr>

                            <tr>
                                <th>Pembimbing</th>
                                <td>{{ $skripsi->supervisor->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>

                                    <span class="badge bg-warning">

                                        {{ ucfirst($skripsi->status) }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>Tanggal Pengajuan</th>

                                <td>{{ $skripsi->submission_date }}</td>

                            </tr>

                        </table>

                    @else

                        <div class="alert alert-info">

                            Belum ada pengajuan skripsi.

                        </div>

                    @endif

                </div>

            </div>

            <div class="card">

                <div class="card-header bg-success text-white">

                    Aksi Cepat

                </div>

                <div class="card-body">

                    <a href="{{ route('student.skripsi.create') }}"
                    class="btn btn-primary">

                        <i class="fa-solid fa-file-circle-plus"></i>

                        Ajukan Skripsi

                    </a>

                    <a href="{{ route('student.skripsi.history') }}"
                    class="btn btn-outline-secondary">

                        <i class="fa-solid fa-clock-rotate-left"></i>

                        Riwayat Pengajuan

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>