@extends('layouts.app')

@section('title', 'Detail Topik')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .status-tag { font-size: 12px; padding: 6px 10px; border-radius: 9999px; }
    .status-open { background: #ecfdf5; color: #166534; }
    .status-closed { background: #e2e8f0; color: #475569; }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-start">
    <div>
        <h1 class="main-title">{{ $topic->title }}</h1>
        <p class="text-muted">Topik oleh {{ $topic->lecturer->name }} ({{ $topic->lecturer->lecturer_id }})</p>
    </div>
    <div>
        <a href="{{ route('topic-board.index') }}" class="btn btn-secondary">Kembali ke Board</a>
    </div>
</div>

<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-column flex-md-row">
        <div>
            <h5>Deskripsi</h5>
            <p>{{ $topic->description }}</p>
        </div>
        <div class="border rounded-3 p-3 bg-light" style="min-width: 220px;">
            <p class="mb-2"><strong>Status</strong></p>
            <span class="status-tag status-{{ $topic->status }}">{{ ucfirst($topic->status) }}</span>
            <hr>
            <p class="mb-1"><strong>Deadline</strong></p>
            <p>{{ $topic->deadline ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="card p-4">
    <h5 class="mb-3">Ajukan Diri</h5>
    <form action="{{ route('topic-board.apply', $topic->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Mahasiswa</label>
                        @if($student)
                            <input type="text" class="form-control" value="{{ $student->name }} ({{ $student->student_id }})" readonly>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                        @else
                            <select name="student_id" class="form-select" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach(\App\Models\Student::orderBy('name')->get() as $s)
                                    <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }} ({{ $s->student_id }})
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
            <div class="col-12">
                <label class="form-label">Pesan / Catatan</label>
                <textarea name="message" class="form-control" rows="3" placeholder="Alasan atau catatan singkat">{{ old('message') }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Ajukan Diri</button>
        </div>
    </form>
</div>
@endsection
