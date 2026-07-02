<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan & Timeline - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }
        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }
        .sub-title {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
        }
        .card-custom {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        .card-header-custom {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            background-color: #ffffff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body-custom {
            padding: 24px;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-pending  { background-color: #fef3c7; color: #d97706; }
        .status-approved { background-color: #dcfce7; color: #15803d; }
        .status-rejected { background-color: #fee2e2; color: #b91c1c; }
        
        .label-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 6px;
        }
        .value-text {
            font-size: 15px;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .value-desc {
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
            background-color: #f8fafc;
            padding: 16px;
            border-radius: 8px;
            border: 1px dashed #cbd5e1;
        }
        .btn-approve { background-color: #10b981; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 20px; border: none; transition: background 0.2s; }
        .btn-approve:hover { background-color: #059669; color: white; }
        .btn-reject { background-color: #ef4444; color: white; font-size: 14px; font-weight: 500; border-radius: 8px; padding: 10px 20px; border: none; transition: background 0.2s; }
        .btn-reject:hover { background-color: #dc2626; color: white; }
        
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 32px;
            margin-left: 8px;
            border-left: 2px solid #e2e8f0;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 32px;
        }
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        .timeline-marker {
            position: absolute;
            left: -44px;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: white;
            box-shadow: 0 0 0 4px #fff;
        }
        .marker-pending { background-color: #d97706; }
        .marker-approved { background-color: #15803d; }
        .marker-rejected { background-color: #b91c1c; }
        
        .timeline-content {
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 16px 20px;
        }
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .timeline-date {
            font-size: 12px;
            color: #94a3b8;
        }
        .timeline-note {
            font-size: 13.5px;
            color: #475569;
            background-color: #ffffff;
            padding: 12px;
            border-radius: 6px;
            border-left: 4px solid #cbd5e1;
            margin-top: 8px;
        }
        .timeline-note-rejected {
            border-left-color: #ef4444;
            background-color: #fef2f2;
        }
        .timeline-note-approved {
            border-left-color: #10b981;
            background-color: #f0fdf4;
        }
        .timeline-actor {
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 1200px;">
        
        <!-- Breadcrumb & Back -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('skripsi.index') }}" class="btn btn-outline-secondary btn-sm" id="btn-back">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            <span class="text-muted small">ID Pengajuan: #{{ $skripsi->id }}</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" id="alert-success">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left Column: Details -->
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <span class="fw-bold fs-5 text-dark"><i class="fa-solid fa-file-invoice me-2 text-primary"></i>Detail Proposal Skripsi</span>
                        <span class="badge-status {{ $skripsi->status == 'pending' ? 'status-pending' : ($skripsi->status == 'approved' ? 'status-approved' : 'status-rejected') }}">
                            {{ $skripsi->status == 'pending' ? 'Menunggu Review' : ($skripsi->status == 'approved' ? 'Disetujui' : 'Ditolak') }}
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="label-title">Mahasiswa</div>
                                <div class="value-text fw-bold text-dark">
                                    {{ $skripsi->student->name ?? '-' }}
                                    <div class="text-muted fw-normal small mt-1">NIM. {{ $skripsi->student->student_id ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="label-title">Dosen Pembimbing Pilihan</div>
                                <div class="value-text fw-semibold text-primary">
                                    <i class="fa-solid fa-user-tie me-1"></i> {{ $skripsi->supervisor->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-3 text-muted">

                        <div class="label-title">Judul Skripsi yang Diajukan</div>
                        <div class="value-text fw-bold text-dark fs-5 mb-4">{{ $skripsi->title }}</div>

                        <div class="label-title">Deskripsi / Abstrak Proposal</div>
                        <div class="value-desc mb-4">{{ $skripsi->description }}</div>

                        @if($skripsi->suggestion_supervisor)
                            <div class="label-title">Saran Dosen Pembimbing Alternatif</div>
                            <div class="value-text text-dark">
                                <i class="fa-solid fa-user-tie me-1 text-secondary"></i> {{ \App\Models\Lecturer::find($skripsi->suggestion_supervisor)->name ?? '-' }}
                            </div>
                        @endif

                        @if($skripsi->elective_courses)
                            <div class="label-title">Nilai Mata Kuliah Pilihan Pendukung</div>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 13.5px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mata Kuliah Pilihan</th>
                                            <th class="text-center" style="width: 15%">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skripsi->elective_courses as $item)
                                            @php $courseId = $item['id'] ?? $item['course_id'] ?? null; @endphp
                                            <tr>
                                                <td>{{ $courseId ? ($courses[$courseId] ?? 'Mata Kuliah #'.$courseId) : '-' }}</td>
                                                <td class="text-center fw-bold text-primary">{{ $item['grade'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <!-- Action panel if pending -->
                        @if($skripsi->status == 'pending')
                            <div class="p-4 bg-light border rounded-3 mt-4">
                                <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-gavel me-2"></i>Evaluasi & Tentukan Status</h6>
                                <div class="d-flex gap-3">
                                    <button class="btn-approve" onclick="executeApprove('{{ $skripsi->id }}')" id="btn-approve-action">
                                        <i class="fa-solid fa-check me-1"></i> Setujui Proposal
                                    </button>
                                    <button class="btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal" onclick="setupReject('{{ $skripsi->id }}')" id="btn-reject-action">
                                        <i class="fa-solid fa-xmark me-1"></i> Tolak Proposal
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Timeline -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <span class="fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i>Timeline Persetujuan</span>
                    </div>
                    <div class="card-body-custom">
                        @if($skripsi->histories->isEmpty())
                            <div class="text-center py-4 text-muted">
                                <i class="fa-regular fa-clock d-block mb-2 fs-4"></i>
                                Belum ada riwayat aktivitas.
                            </div>
                        @else
                            <div class="timeline">
                                @foreach($skripsi->histories as $history)
                                    <div class="timeline-item">
                                        <!-- Marker Icon -->
                                        @php
                                            $markerClass = 'marker-pending';
                                            $markerIcon = 'fa-paper-plane';
                                            if ($history->status === 'approved') {
                                                $markerClass = 'marker-approved';
                                                $markerIcon = 'fa-check';
                                            } elseif ($history->status === 'rejected') {
                                                $markerClass = 'marker-rejected';
                                                $markerIcon = 'fa-xmark';
                                            }
                                        @endphp
                                        <div class="timeline-marker {{ $markerClass }}">
                                            <i class="fa-solid {{ $markerIcon }}"></i>
                                        </div>

                                        <!-- Timeline Content -->
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <span class="timeline-title">
                                                    @if($history->status === 'pending')
                                                        Pengajuan Awal
                                                    @elseif($history->status === 'approved')
                                                        Disetujui
                                                    @elseif($history->status === 'rejected')
                                                        Ditolak
                                                    @else
                                                        Status Diperbarui
                                                    @endif
                                                </span>
                                                <span class="timeline-date">{{ $history->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                            
                                            <!-- Note Box -->
                                            @if($history->note)
                                                <div class="timeline-note {{ $history->status === 'approved' ? 'timeline-note-approved' : ($history->status === 'rejected' ? 'timeline-note-rejected' : '') }}">
                                                    {{ $history->note }}
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form hidden untuk submit status --}}
    <form id="updateStatusForm" method="POST" action="" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="formStatus">
        <input type="hidden" name="rejection_note" id="formRejectionNote">
    </form>

    {{-- Modal Reject --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger" id="modal-reject-title">Tolak Pengajuan Skripsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">
                            Catatan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="modalRejectionNote" rows="3" placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="submitReject()" id="btn-confirm-reject">
                        Konfirmasi Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
