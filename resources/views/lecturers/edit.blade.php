@extends('layouts.app')

@section('title', 'Edit Dosen')

@push('styles')
<style>
body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); padding: 32px; }
        .form-label-custom { font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }
        .btn-save { background-color: #10b981; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: none; }
        .btn-save:hover { background-color: #059669; color: white; }
        .btn-back-custom { background-color: transparent; color: #64748b; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: 1px solid #e2e8f0; text-decoration: none; }
        .btn-back-custom:hover { background-color: #f1f5f9; color: #334155; }
</style>
@endpush

@section('content')

<div class="container py-5" style="max-width: 700px;">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Gagal menyimpan:</strong>
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
                <h1 class="main-title">Edit Data Dosen</h1>
                <p class="sub-title">Perbarui informasi dosen yang terdaftar.</p>
            </div>
            <a href="{{ route('lecturers.index') }}" class="btn-back-custom">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="content-card">
            <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="lecturer_id" class="form-label-custom">NIDN / ID Dosen</label>
                    <input
                        type="text"
                        id="lecturer_id"
                        name="lecturer_id"
                        class="form-control"
                        value="{{ old('lecturer_id', $lecturer->lecturer_id) }}"
                        placeholder="Contoh: LCT001"
                    >
                    <div class="form-hint">Nomor identitas dosen</div>
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label-custom">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $lecturer->name) }}"
                        placeholder="Contoh: Prof. Dr. Ahmad"
                        autofocus
                    >
                    <div class="form-hint">Nama lengkap beserta gelar</div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $lecturer->email) }}"
                        placeholder="Contoh: dosen@uad.ac.id"
                    >
                    <div class="form-hint">Alamat email aktif</div>
                </div>

                <div class="mb-4">
                    <label for="expertise" class="form-label-custom">Keahlian</label>
                    <input
                        type="text"
                        id="expertise"
                        name="expertise"
                        class="form-control"
                        value="{{ old('expertise', $lecturer->expertise) }}"
                        placeholder="Contoh: Machine Learning, Data Mining"
                    >
                    <div class="form-hint">Bidang keahlian dosen (opsional)</div>
                </div>

                <div class="mb-4">
                    <label for="max_supervisors" class="form-label-custom">Maks. Mahasiswa Bimbingan per Angkatan</label>
                    <input
                        type="number"
                        id="max_supervisors"
                        name="max_supervisors"
                        class="form-control"
                        value="{{ old('max_supervisors', $lecturer->max_supervisors ?? 3) }}"
                        min="1"
                        placeholder="Contoh: 3"
                    >
                    <div class="form-hint">Jumlah maksimal mahasiswa yang dapat dibimbing per angkatan</div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('lecturers.index') }}" class="btn-back-custom">Batal</a>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection