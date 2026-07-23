@extends('layouts.app')

@section('title', 'Edit Topik Dosen')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .form-label { font-weight: 600; color: #334155; }
</style>
@endpush

@section('content')
<div class="mb-4">
    <h1 class="main-title">Edit Topik Dosen</h1>
    <p class="text-muted">Perbarui data topik yang sudah dibuat.</p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('lecturer-topics.update', $topic->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Pilih Dosen</label>
                <select name="lecturer_id" class="form-select" required>
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}" {{ old('lecturer_id', $topic->lecturer_id) == $lecturer->id ? 'selected' : '' }}>
                            {{ $lecturer->name }} ({{ $lecturer->lecturer_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Topik</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $topic->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $topic->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Persyaratan</label>
                <textarea name="requirements" class="form-control" rows="3">{{ old('requirements', $topic->requirements) }}</textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $topic->capacity) }}" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="open" {{ old('status', $topic->status) === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="filled" {{ old('status', $topic->status) === 'filled' ? 'selected' : '' }}>Filled</option>
                        <option value="closed" {{ old('status', $topic->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Batas Waktu</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $topic->deadline) }}">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('lecturer-topics.show', $topic->id) }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui Topik</button>
            </div>
        </form>
    </div>
</div>
@endsection
