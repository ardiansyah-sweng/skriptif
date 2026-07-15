@extends('layouts.app')

@section('title', 'Tambah Jadwal Sidang')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .meta-text { font-size: 12px; color: #64748b; }
    .btn-back { font-size: 14px; color: #2563eb; text-decoration: none; font-weight: 500; }
    .btn-back:hover { color: #1d4ed8; text-decoration: underline; }
    .btn-submit { background-color: #2563eb; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 24px; border: none; }
    .btn-submit:hover { background-color: #1d4ed8; color: white; }
</style>
@endpush

@section('content')
    <div style="max-width: 800px;">

        <div class="mb-4">
            <a href="{{ route('exam-schedules.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Jadwal
            </a>
        </div>

        <div class="mb-4">
            <h1 class="main-title">Tambah Jadwal Sidang</h1>
            <p class="sub-title">Buat jadwal sidang baru untuk skripsi yang sudah disetujui.</p>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <span class="fw-bold text-dark">Form Jadwal Sidang</span>
            </div>
            <div class="p-4">
                <form action="{{ route('exam-schedules.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="skripsi_id" class="form-label small fw-bold text-secondary">
                            Skripsi <span class="text-danger">*</span>
                        </label>
                        <select name="skripsi_id" id="skripsi_id" class="form-select @error('skripsi_id') is-invalid @enderror">
                            <option value="">— Pilih Skripsi —</option>
                            @foreach($approvedSkripsi as $skripsi)
                                <option value="{{ $skripsi->id }}" {{ old('skripsi_id') == $skripsi->id ? 'selected' : '' }}>
                                    {{ $skripsi->student->name ?? '-' }} — {{ $skripsi->title }}
                                </option>
                            @endforeach
                        </select>
                        <div class="meta-text mt-1">(Hanya skripsi yang sudah disetujui)</div>
                        @error('skripsi_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_sidang" class="form-label small fw-bold text-secondary">
                            Jenis Sidang <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_sidang" id="jenis_sidang" class="form-select @error('jenis_sidang') is-invalid @enderror">
                            <option value="">— Pilih Jenis Sidang —</option>
                            <option value="proposal" {{ old('jenis_sidang') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                            <option value="pendadaran" {{ old('jenis_sidang') == 'pendadaran' ? 'selected' : '' }}>Pendadaran</option>
                        </select>
                        @error('jenis_sidang')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_sidang" class="form-label small fw-bold text-secondary">
                            Tanggal Sidang <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_sidang" id="tanggal_sidang"
                               class="form-control @error('tanggal_sidang') is-invalid @enderror"
                               value="{{ old('tanggal_sidang') }}">
                        @error('tanggal_sidang')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="jam_mulai" class="form-label small fw-bold text-secondary">
                                Jam Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="jam_mulai" id="jam_mulai"
                                   class="form-control @error('jam_mulai') is-invalid @enderror"
                                   value="{{ old('jam_mulai') }}">
                            @error('jam_mulai')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="jam_selesai" class="form-label small fw-bold text-secondary">
                                Jam Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="jam_selesai" id="jam_selesai"
                                   class="form-control @error('jam_selesai') is-invalid @enderror"
                                   value="{{ old('jam_selesai') }}">
                            @error('jam_selesai')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ruang" class="form-label small fw-bold text-secondary">
                            Ruang Sidang <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="ruang" id="ruang"
                               class="form-control @error('ruang') is-invalid @enderror"
                               value="{{ old('ruang') }}" placeholder="Contoh: R. Sidang A">
                        @error('ruang')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label small fw-bold text-secondary">
                            Catatan <span class="text-muted">(opsional)</span>
                        </label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="form-control @error('catatan') is-invalid @enderror"
                                  placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
