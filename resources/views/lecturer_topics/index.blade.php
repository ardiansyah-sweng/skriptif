@extends('layouts.app')

@section('title', 'Papan Topik Dosen')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .meta-text { font-size: 12px; color: #64748b; }
    .btn-detail-action { background-color: #64748b; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
    .btn-edit-action { background-color: #3b82f6; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; text-decoration: none; }
    .btn-delete-action { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
    .btn-add-action { background-color: #10b981; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 8px 16px; border: none; text-decoration: none; }
    .btn-add-action:hover { background-color: #0f766e; }
    .btn-detail-action:hover { background-color: #475569; }
    .btn-edit-action:hover { background-color: #2563eb; }
    .btn-delete-action:hover { background-color: #dc2626; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="main-title">Papan Topik Dosen</h1>
        <p class="sub-title">Kelola topik skripsi dan proyek yang ditawarkan oleh dosen.</p>
    </div>
    <div>
        <a href="{{ route('lecturer-topics.create') }}" class="btn btn-sm btn-success">
            <i class="fa-solid fa-plus"></i> Tambah Topik Baru
        </a>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark">Daftar Topik</span>
        <span class="meta-text"><i class="fa-solid fa-book-bookmark me-1"></i> {{ $topics->count() }} topik</span>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 24%">Judul Topik</th>
                    <th style="width: 20%">Dosen</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 34%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topics as $index => $topic)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold">{{ $topic->title }}</div>
                        <div class="meta-text">{{ Str::limit($topic->description, 80) }}</div>
                    </td>
                    <td>
                        <div class="meta-text">{{ $topic->lecturer->name }}</div>
                        <div class="meta-text">{{ $topic->lecturer->lecturer_id }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $topic->status === 'open' ? 'success' : 'secondary' }}">{{ ucfirst($topic->status) }}</span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('lecturer-topics.show', $topic->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('lecturer-topics.edit', $topic->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('lecturer-topics.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Hapus topik "{{ $topic->title }}" secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        Tidak ada topik dosen.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
