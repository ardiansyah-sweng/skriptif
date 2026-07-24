@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title mb-1">Profil Akun Mahasiswa</h5>
                    <p class="text-muted small mb-4">Informasi akun mahasiswa yang sedang digunakan.</p>

                    @if (! $isEditing)
                        <dl class="row mb-4">
                            <dt class="col-sm-4 text-muted fw-normal">Nama</dt>
                            <dd class="col-sm-8">{{ $user->name }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Email</dt>
                            <dd class="col-sm-8">{{ $user->email }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal">Peran</dt>
                            <dd class="col-sm-8">Mahasiswa</dd>
                        </dl>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('student.password.edit') }}" class="btn btn-outline-secondary">Ganti Password</a>
                            <a href="{{ route('student.profile.show', ['edit' => 1]) }}" class="btn btn-primary">Ubah Profil</a>
                        </div>
                    @else
                    <form action="{{ route('student.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Peran</label>
                            <input type="text" value="Mahasiswa" class="form-control" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('student.profile.show') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
