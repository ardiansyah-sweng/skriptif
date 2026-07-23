@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@push('styles')
<style>
    .welcome-banner {
        background: #185FA5;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%; right: -10%;
        width: 350px; height: 350px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-banner h2 { font-size: 1.75rem; font-weight: 700; position: relative; z-index: 1; }
    .welcome-banner p { font-size: 1rem; opacity: 0.9; position: relative; z-index: 1; }
    .welcome-banner .welcome-icon {
        font-size: 64px; opacity: 0.15;
        position: absolute; right: 2rem; top: 50%; transform: translateY(-50%);
    }
    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
    .stat-card .stat-number { font-size: 2rem; font-weight: 800; line-height: 1.1; }
    .stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; font-weight: 500; }
    .card { border: none; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .card-header-custom {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem; border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 600;
    }
    .table thead th { border-bottom: 2px solid #e9ecef; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; }
    .quick-action-btn { border-radius: 12px; padding: 0.7rem 1.2rem; font-weight: 500; transition: all 0.3s ease; }
    .quick-action-btn:hover { transform: translateY(-2px); }
</style>
@endpush

@section('content')
<div class="welcome-banner text-white mb-4">
    <h2>Selamat Datang, {{ $lecturer->name ?? Auth::user()->name }}</h2>
    <p class="mb-0">Dashboard Dosen — Pantau bimbingan dan jadwal sidang mahasiswa.</p>
    <i class="fa-solid fa-chalkboard-user welcome-icon"></i>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: #4a7cbf;">
            <div class="stat-number">{{ $bimbinganCount }}</div>
            <div class="stat-label">Mahasiswa Bimbingan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: #e67e22;">
            <div class="stat-number">{{ $topicCount }}</div>
            <div class="stat-label">Topik Dosen</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: #4a9c6f;">
            <div class="stat-number">{{ $upcomingSchedules->count() }}</div>
            <div class="stat-label">Jadwal Sidang Mendatang</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: #7a6fa8;">
            <div class="stat-number">{{ $totalAnnouncements }}</div>
            <div class="stat-label">Pengumuman</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-calendar-check text-warning"></i> Jadwal Sidang Mendatang</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingSchedules as $s)
                            <tr>
                                <td class="fw-medium">{{ $s->skripsi->student->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_sidang)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $s->ruang }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada jadwal sidang mendatang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-book text-success"></i> Log Book Terbaru</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogBooks as $lb)
                            <tr>
                                <td class="fw-medium">{{ $lb->student->name ?? '-' }}</td>
                                <td>{{ $lb->date ? \Carbon\Carbon::parse($lb->date)->format('d/m/Y') : $lb->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $lb->status === 'approved' ? 'success' : ($lb->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($lb->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada log book.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-lightbulb text-warning"></i> Topik Dosen</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="collapse" data-bs-target="#createTopicForm" onclick="event.stopPropagation()">
                        <i class="fa-solid fa-plus"></i> Tambah Topik
                    </button>
                </div>
            </div>

            {{-- Form Tambah Topik (Collapse) --}}
            <div class="collapse {{ $errors->any() ? 'show' : '' }}" id="createTopicForm">
                <div class="p-4 border-bottom bg-light">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle text-success"></i> Tambah Topik Baru</h6>
                    <form action="{{ route('lecturer-topics.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Judul Topik</label>
                                <input type="text" name="titles[]" class="form-control form-control-sm" placeholder="Judul topik" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" name="capacities[]" class="form-control form-control-sm" value="1" min="1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Batas Waktu</label>
                                <input type="date" name="deadlines[]" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="descriptions[]" class="form-control form-control-sm" rows="2" placeholder="Deskripsi topik" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Persyaratan (opsional)</label>
                                <textarea name="requirements[]" class="form-control form-control-sm" rows="2" placeholder="Persyaratan"></textarea>
                            </div>
                            <input type="hidden" name="lecturer_id" value="{{ $lecturer->id ?? '' }}">
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-save"></i> Simpan Topik</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#createTopicForm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar Topik --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul Topik</th>
                                <th>Status</th>
                                <th>Deadline</th>
                                <th>Kapasitas</th>
                                <th>Pendaftar</th>
                                <th style="width: 220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topics as $t)
                            <tr>
                                <td class="fw-medium">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="collapse" data-bs-target="#topicDetail{{ $t->id }}" onclick="event.preventDefault();">
                                        {{ $t->title }}
                                    </a>
                                    <div class="meta-text">{{ Str::limit($t->description, 60) }}</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $t->status === 'open' ? 'success' : ($t->status === 'filled' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td>{{ $t->deadline ? \Carbon\Carbon::parse($t->deadline)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $t->capacity }}</td>
                                <td>
                                    <span class="badge bg-info rounded-pill">{{ $t->applications_count }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" data-bs-target="#topicDetail{{ $t->id }}" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#editTopic{{ $t->id }}" title="Edit" onclick="event.preventDefault();">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('lecturer-topics.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus topik "{{ $t->title }}"?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row Detail & Aplikasi Mahasiswa (Collapse) --}}
                            <tr class="collapse-row">
                                <td colspan="6" class="p-0">
                                    <div class="collapse bg-light" id="topicDetail{{ $t->id }}">
                                        <div class="p-4">
                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <h6 class="fw-bold">{{ $t->title }}</h6>
                                                    <p class="mb-1"><strong>Deskripsi:</strong> {{ $t->description }}</p>
                                                    @if($t->requirements)
                                                        <p class="mb-1"><strong>Persyaratan:</strong> {{ $t->requirements }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="border rounded-3 p-3 bg-white">
                                                        <p class="mb-1"><strong>Status:</strong> 
                                                            <span class="badge bg-{{ $t->status === 'open' ? 'success' : ($t->status === 'filled' ? 'warning' : 'secondary') }}">
                                                                {{ ucfirst($t->status) }}
                                                            </span>
                                                        </p>
                                                        <p class="mb-1"><strong>Batas waktu:</strong> {{ $t->deadline ? \Carbon\Carbon::parse($t->deadline)->format('d/m/Y') : '-' }}</p>
                                                        <p class="mb-1"><strong>Kapasitas:</strong> {{ $t->capacity }}</p>
                                                        <p class="mb-0"><strong>Pendaftar:</strong> {{ $t->applications_count }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="fw-bold mb-2">Aplikasi Mahasiswa</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0 bg-white">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Mahasiswa</th>
                                                            <th>Status</th>
                                                            <th>Pesan</th>
                                                            <th>Tanggal</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($t->applications as $idx => $app)
                                                        <tr>
                                                            <td>{{ $idx + 1 }}</td>
                                                            <td>{{ $app->student?->name }} ({{ $app->student?->student_id }})</td>
                                                            <td>
                                                                <span class="badge bg-{{ $app->status === 'approved' ? 'success' : ($app->status === 'pending' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($app->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $app->message ?? '-' }}</td>
                                                            <td>{{ $app->created_at->format('d/m/Y') }}</td>
                                                            <td>
                                                                @if($app->status === 'pending')
                                                                    <form action="{{ route('topic-applications.approve', $app->id) }}" method="POST" style="display:inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui aplikasi ini?')"><i class="fa-solid fa-check"></i></button>
                                                                    </form>
                                                                    <form action="{{ route('topic-applications.reject', $app->id) }}" method="POST" style="display:inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak aplikasi ini?')"><i class="fa-solid fa-times"></i></button>
                                                                    </form>
                                                                @endif
                                                                <form action="{{ route('topic-applications.destroy', $app->id) }}" method="POST" style="display:inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus aplikasi?')"><i class="fa-solid fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">Belum ada aplikasi.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row Edit Topik (Collapse) --}}
                            <tr class="collapse-row">
                                <td colspan="6" class="p-0">
                                    <div class="collapse bg-light" id="editTopic{{ $t->id }}">
                                        <div class="p-4 border-bottom">
                                            <h6 class="fw-bold mb-3"><i class="fa-solid fa-pen-to-square text-primary"></i> Edit Topik: {{ $t->title }}</h6>
                                            <form action="{{ route('lecturer-topics.update', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="lecturer_id" value="{{ $t->lecturer_id }}">
                                                <div class="row g-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" name="title" class="form-control form-control-sm" value="{{ $t->title }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Kapasitas</label>
                                                        <input type="number" name="capacity" class="form-control form-control-sm" value="{{ $t->capacity }}" min="1">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select form-select-sm">
                                                            <option value="open" {{ $t->status === 'open' ? 'selected' : '' }}>Open</option>
                                                            <option value="filled" {{ $t->status === 'filled' ? 'selected' : '' }}>Filled</option>
                                                            <option value="closed" {{ $t->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Batas Waktu</label>
                                                        <input type="date" name="deadline" class="form-control form-control-sm" value="{{ $t->deadline }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea name="description" class="form-control form-control-sm" rows="2" required>{{ $t->description }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Persyaratan</label>
                                                        <textarea name="requirements" class="form-control form-control-sm" rows="2">{{ $t->requirements }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-3 d-flex gap-2">
                                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#editTopic{{ $t->id }}">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox fs-3 d-block mb-2"></i>
                                    Belum ada topik dosen. Klik "Tambah Topik" untuk membuat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom">
                <span><i class="fa-solid fa-bolt text-warning"></i> Aksi Cepat</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('log-books.index') }}" class="btn btn-outline-success quick-action-btn">
                        <i class="fa-solid fa-book me-1"></i> Log Book
                    </a>
                    <a href="{{ route('exam-schedules.index') }}" class="btn btn-outline-warning quick-action-btn">
                        <i class="fa-solid fa-calendar-check me-1"></i> Jadwal Sidang
                    </a>
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-dark quick-action-btn">
                        <i class="fa-solid fa-bullhorn me-1"></i> Pengumuman
                    </a>
                    <a href="{{ route('topic-board.index') }}" class="btn btn-outline-info quick-action-btn">
                        <i class="fa-solid fa-chalkboard"></i> Papan Topik
                    </a>
                    <a href="{{ route('topic-applications.index') }}" class="btn btn-outline-warning quick-action-btn">
                        <i class="fa-solid fa-file-signature"></i> Aplikasi Topik
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
