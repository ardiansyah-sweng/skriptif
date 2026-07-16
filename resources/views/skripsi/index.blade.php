@extends('layouts.app')

@section('title', 'Persetujuan Pengajuan Skripsi')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; }
    .status-pending  { background-color: #fef3c7; color: #d97706; }
    .status-approved { background-color: #dcfce7; color: #15803d; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; }
    .btn-approve { background-color: #10b981; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
    .btn-approve:hover { background-color: #059669; color: white; }
    .btn-reject { background-color: #ef4444; color: white; font-size: 13px; font-weight: 500; border-radius: 6px; padding: 6px 14px; border: none; }
    .btn-reject:hover { background-color: #dc2626; color: white; }
    .meta-text { font-size: 12px; color: #64748b; }
</style>
@endpush

@section('content')
    <div style="max-width: 1200px;">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Gagal memperbarui:</strong>
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
                <h1 class="main-title">Persetujuan Pengajuan Skripsi</h1>
                <p class="sub-title">Evaluasi usulan judul mahasiswa. Dosen pembimbing sudah dipilih oleh mahasiswa.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="content-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Pengajuan</small>
                            <h3 class="fw-bold mb-0">{{ $total }}</h3>
                            <small class="text-muted">Semua Data</small>
                        </div>
                        <i class="fa-solid fa-folder-open text-primary fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Pending</small>
                            <h3 class="fw-bold mb-0">{{ $pending }}</h3>
                            <small class="text-warning">Menunggu Review</small>
                        </div>
                        <i class="fa-solid fa-clock text-warning fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Approved</small>
                            <h3 class="fw-bold mb-0">{{ $approved }}</h3>
                            <small class="text-success">Sudah Disetujui</small>
                        </div>
                        <i class="fa-solid fa-circle-check text-success fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Rejected</small>
                            <h3 class="fw-bold mb-0">{{ $rejected }}</h3>
                            <small class="text-danger">Sudah Ditolak</small>
                        </div>
                        <i class="fa-solid fa-circle-xmark text-danger fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <form method="GET" class="p-3 border-bottom">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Cari mahasiswa, NIM atau judul..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                                </button>
                                <a href="{{ route('skripsi.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <span class="fw-bold text-dark">Daftar Antrean Skripsi</span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 22%">Mahasiswa / NIM</th>
                            <th style="width: 38%">Usulan Judul & Dosen</th>
                            <th style="width: 15%" class="text-center">Status</th>
                            <th style="width: 20%" class="text-center">Aksi Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allSkripsi as $key => $skripsi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $skripsi->student->name ?? '-' }}</div>
                                <div class="meta-text">NIM. {{ $skripsi->student->student_id ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $skripsi->title }}</div>
                                @if($skripsi->supervisor)
                                    <div class="meta-text mt-1 text-primary">
                                        <i class="fa-solid fa-user-tie me-1"></i> Pembimbing: {{ $skripsi->supervisor->name }}
                                    </div>
                                @endif
                                @if($skripsi->rejection_note)
                                    <div class="meta-text mt-1 text-danger">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $skripsi->rejection_note }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($skripsi->status == 'pending')
                                    <span class="badge-status status-pending"><i class="fa-solid fa-clock"></i> Menunggu Review</span>
                                @elseif($skripsi->status == 'approved')
                                    <span class="badge-status status-approved"><i class="fa-solid fa-check"></i> Disetujui</span>
                                @else
                                    <span class="badge-status status-rejected"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($skripsi->status == 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn-approve" onclick="executeApprove('{{ $skripsi->id }}')">
                                            <i class="fa-solid fa-check"></i> Setujui
                                        </button>
                                        <button class="btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                onclick="setupReject('{{ $skripsi->id }}')">
                                            <i class="fa-solid fa-xmark"></i> Tolak
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted meta-text">
                                        <i class="fa-solid fa-lock me-1"></i> Locked
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px;"></i>
                                Tidak ada data pengajuan skripsi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="updateStatusForm" method="POST" action="" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="formStatus">
        <input type="hidden" name="rejection_note" id="formRejectionNote">
    </form>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Tolak Pengajuan Skripsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">
                            Catatan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="modalRejectionNote" rows="3"
                                  placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="submitReject()">
                        Konfirmasi Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentSkripsiId = null;

        function executeApprove(id) {
            if (confirm('Setujui pengajuan skripsi ini?')) {
                const form = document.getElementById('updateStatusForm');
                form.action = `/skripsi/${id}/update-status`;
                document.getElementById('formStatus').value = 'approved';
                document.getElementById('formRejectionNote').value = '';
                form.submit();
            }
        }

        function setupReject(id) {
            currentSkripsiId = id;
            document.getElementById('modalRejectionNote').value = '';
        }

        function submitReject() {
            const note = document.getElementById('modalRejectionNote').value.trim();
            if (!note) {
                alert('Catatan penolakan wajib diisi!');
                return;
            }
            const form = document.getElementById('updateStatusForm');
            form.action = `/skripsi/${currentSkripsiId}/update-status`;
            document.getElementById('formStatus').value = 'rejected';
            document.getElementById('formRejectionNote').value = note;
            form.submit();
        }
    </script>
@endsection
