@extends('layouts.app')

@section('title', 'Tambah Student')

@push('styles')
<style>
    .wrap { max-width: 820px; }
    .hero {
        display: flex; justify-content: space-between; gap: 16px; align-items: flex-end;
        margin-bottom: 20px; padding-bottom: 18px; border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    }
    .crumb { display: inline-flex; gap: 6px; align-items: center; font-size: 12px; color: #64748b; margin-bottom: 10px; }
    h1 { margin: 0; font-size: 28px; letter-spacing: -0.03em; }
    .sub { margin: 8px 0 0; color: #64748b; font-size: 14px; }
    .back {
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none; background: #fff;
        color: #334155; border: 1px solid #dbe3ee; border-radius: 12px; padding: 11px 14px; font-weight: 600;
    }
    .back:hover { background: #f8fafc; }
    .card {
        background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 20px; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08); overflow: hidden;
    }
    .card-head { padding: 18px 20px; border-bottom: 1px solid #eef2f7; background: #fbfdff; }
    .card-head strong { display: block; font-size: 16px; }
    .card-head span { color: #64748b; font-size: 13px; }
    form { padding: 20px; }
    .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    .field { display: flex; flex-direction: column; gap: 8px; }
    .field.full { grid-column: 1 / -1; }
    label { font-size: 13px; font-weight: 700; color: #334155; }
    input, select {
        width: 100%; border: 1px solid #dbe3ee; border-radius: 12px; padding: 12px 14px;
        font-size: 14px; outline: none; background: #fff;
    }
    input:focus, select:focus { border-color: #185FA5; box-shadow: 0 0 0 4px rgba(24, 95, 165, 0.12); }
    .hint { font-size: 12px; color: #94a3b8; }
    .error { font-size: 12px; color: #b91c1c; }
    .actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }
    .ghost, .primary {
        display: inline-flex; align-items: center; gap: 8px; border-radius: 12px; padding: 12px 16px;
        text-decoration: none; font-weight: 700; border: 1px solid transparent; cursor: pointer;
    }
    .ghost { background: #fff; border-color: #dbe3ee; color: #334155; }
    .ghost:hover { background: #f8fafc; }
    .primary { background: #185FA5; color: #fff; }
    .primary:hover { background: #0c447c; }
    @media (max-width: 720px) {
        .hero { flex-direction: column; align-items: stretch; }
        .grid { grid-template-columns: 1fr; }
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
                    <a href="{{ route('students.index') }}" style="color:#64748b;text-decoration:none">Students</a>
                    <i class="ti ti-chevron-right"></i>
                    <span>Tambah</span>
                </div>
                <h1>Tambah Student</h1>
                <p class="sub">Isi data mahasiswa baru sesuai format yang dipakai di tabel students.</p>
            </div>
            <a href="{{ route('students.index') }}" class="back"><i class="ti ti-arrow-left"></i> Kembali</a>
        </div>

        <div class="card">
            <div class="card-head">
                <strong>Form Data Student</strong>
                <span>Semua field wajib diisi, kecuali status yang tetap dipilih manual.</span>
            </div>

            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="grid">
                    <div class="field">
                        <label for="student_id">Student ID</label>
                        <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}" placeholder="STU-2026-006">
                        @error('student_id') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="year_entrance">Angkatan</label>
                        <input type="number" id="year_entrance" name="year_entrance" value="{{ old('year_entrance') }}" placeholder="2024" min="1900" max="2100">
                        @error('year_entrance') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field full">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama mahasiswa">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('students.index') }}" class="ghost">Batal</a>
                    <button type="submit" class="primary"><i class="ti ti-device-floppy"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
