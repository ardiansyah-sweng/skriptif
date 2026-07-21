@extends('layouts.app')

@section('title', 'Daftar Skripsi')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Pengajuan Skripsi</h5>
            </div>
            <div class="card-body p-0">
                @if(isset($skripsis) && $skripsis->count())
                    <ul class="list-group list-group-flush">
                        @foreach($skripsis as $item)
                            <li class="list-group-item">
                                <a href="{{ route('student.skripsi.show', $item->id) }}" class="text-decoration-none text-dark">
                                    <strong>{{ $item->title }}</strong><br>
                                    <small class="text-muted">Pembimbing: {{ $item->supervisor->name ?? '-' }}</small><br>
                                    <small class="text-muted">Status: {{ ucfirst($item->status) }}</small>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3 text-muted">Belum ada data skripsi.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Skripsi</h5>
                    @if(isset($skripsi) && $skripsi)
                        <button id="editBtn" class="btn btn-sm btn-outline-primary" onclick="showEdit()">Edit</button>
                    @endif
                </div>
                <div class="card-body">
                    @if(isset($skripsi) && $skripsi)
                        <div id="detailView">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul</label>
                                <div>{{ $skripsi->title }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <div>{{ $skripsi->description }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pembimbing</label>
                                <div>{{ $skripsi->supervisor->name ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div>{{ ucfirst($skripsi->status) }}</div>
                            </div>
                        </div>

                        <div id="editForm" style="display:none;">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('student.skripsi.update', $skripsi->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Judul</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $skripsi->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Deskripsi</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $skripsi->description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="supervisor_id" class="form-label fw-bold">Pembimbing</label>
                                    <select id="supervisor_id" name="supervisor_id" class="form-select" required>
                                        <option value="">-- Pilih Pembimbing --</option>
                                        @foreach($lecturers ?? [] as $lecturer)
                                            <option value="{{ $lecturer->id }}" {{ (old('supervisor_id', $skripsi->supervisor_id) == $lecturer->id) ? 'selected' : '' }}>{{ $lecturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="cancelEdit()">Batal</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="text-muted">Silakan pilih salah satu skripsi untuk melihat detail.</div>
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showEdit() {
        document.getElementById('detailView').style.display = 'none';
        document.getElementById('editForm').style.display = 'block';
        var btn = document.getElementById('editBtn');
        if (btn) btn.style.display = 'none';
    }

    function cancelEdit() {
        document.getElementById('detailView').style.display = 'block';
        document.getElementById('editForm').style.display = 'none';
        var btn = document.getElementById('editBtn');
        if (btn) btn.style.display = 'inline-block';
    }
</script>
@endpush
