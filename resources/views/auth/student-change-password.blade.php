@extends('layouts.app')

@section('title', 'Keamanan Akun Mahasiswa')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title mb-1">Ganti Password Mahasiswa</h5>
                    <p class="text-muted small mb-4">Gunakan password baru minimal delapan karakter untuk menjaga keamanan akun.</p>

                    <form action="{{ route('student.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input id="current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('student.profile.show') }}" class="btn btn-outline-secondary">Kembali ke Profil</a>
                            <button type="submit" class="btn btn-primary">Perbarui Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
