
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Log Book Bimbingan - Skriptif</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
        .form-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); padding: 30px; }
        .btn-submit { background-color: #1e293b; color: white; font-size: 14px; font-weight: 500; border-radius: 6px; padding: 10px 24px; border: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-submit:hover { background-color: #0f172a; }
        .btn-cancel { background-color: transparent; color: #64748b; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; border-radius: 6px; padding: 10px 24px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-cancel:hover { background-color: #f1f5f9; color: #334155; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; padding: 10px 14px; color: #0f172a; }
        .form-control:focus, .form-select:focus { border-color: #94a3b8; box-shadow: none; }
        .crumb { font-size: 12px; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .crumb a { color: #64748b; text-decoration: none; }
        .crumb a:hover { color: #0f172a; }
        .hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 800px;">
        <div class="crumb">
            <i class="fa-solid fa-house"></i>
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px;"></i>
            <a href="{{ route('log-books.index') }}">Log Book Bimbingan</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 8px;"></i>
            <span class="fw-semibold" style="color: #0f172a;">Tambah</span>
        </div>
        <div class="mb-4">
            <h1 class="main-title">Tambah Catatan Bimbingan</h1>
            <p class="sub-title">Isi data di bawah ini setelah melakukan sesi konsultasi/bimbingan dengan dosen pembimbing.</p>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" style="background-color: #fee2e2; color: #b91c1c; border-radius: 8px;">
                <i class="fa-solid fa-circle-xmark me-2"></i> <strong>Gagal menyimpan data:</strong>
                <ul class="mb-0 mt-1" style="font-size: 13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="form-card">
            <!-- enctype="multipart/form-data" ditambahkan agar form ini mendukung unggah berkas (file upload) -->
            <form action="{{ route('log-books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Student Select -->
                <div class="mb-4">
                    <label for="student_id" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Mahasiswa...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" data-supervisor="{{ $student->skripsi?->supervisor_id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} (NIM. {{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Pilih nama mahasiswa yang melakukan bimbingan.</div>
                </div>
                <!-- Lecturer Select -->
                <div class="mb-4">
                    <label for="lecturer_id" class="form-label">Dosen Pembimbing <span class="text-danger">*</span></label>
                    <select name="lecturer_id" id="lecturer_id" class="form-select @error('lecturer_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Dosen Pembimbing...</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->name }} (Fokus: {{ $lecturer->expertise ?? 'Umum' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Pilih dosen yang memberikan bimbingan.</div>
                </div>
                <!-- Guidance Date -->
                <div class="mb-4">
                    <label for="date" class="form-label">Tanggal Bimbingan <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                    <div class="hint">Tentukan tanggal kapan sesi konsultasi berlangsung.</div>
                </div>
                <!-- Guidance Activity -->
                <div class="mb-4">
                    <label for="activity" class="form-label">Laporan Aktivitas / Progress <span class="text-danger">*</span></label>
                    <textarea name="activity" id="activity" rows="5" class="form-control @error('activity') is-invalid @enderror" placeholder="Tuliskan pokok pembahasan, progres pengerjaan, atau materi yang dikonsultasikan saat bimbingan..." required>{{ old('activity') }}</textarea>
                    <div class="hint">Minimal 5 karakter. Berikan rincian ringkas tapi padat mengenai hasil diskusi.</div>
                </div>
                <!-- Guidance Feedback (Optional) -->
                <div class="mb-4">
                    <label for="feedback" class="form-label">Feedback / Catatan Dosen (Opsional)</label>
                    <textarea name="feedback" id="feedback" rows="3" class="form-control @error('feedback') is-invalid @enderror" placeholder="Feedback, revisi, atau saran perbaikan dari dosen pembimbing (jika ada)...">{{ old('feedback') }}</textarea>
                    <div class="hint">Dapat diisi langsung oleh dosen atau disalin oleh mahasiswa sesuai hasil bimbingan.</div>
                </div>
                <!-- Verification Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">Status Bimbingan <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved (Telah Disetujui)</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak / Perlu Pengajuan Ulang)</option>
                    </select>
                    <div class="hint">Status default bimbingan adalah 'Pending' sampai disetujui oleh dosen pembimbing.</div>
                </div>
                <!-- Input file untuk mengunggah lampiran bimbingan (bersifat opsional) -->
                <!-- Guidance Attachment (Optional) -->
                <div class="mb-4">
                    <label for="attachment" class="form-label">Lampiran Dokumen / Gambar (Opsional)</label>
                    <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror" accept="image/*,application/pdf">
                    <div class="hint">Format: JPEG, PNG, JPG, PDF. Maksimal 2MB.</div>
                </div>
                <!-- Actions -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                    <a href="{{ route('log-books.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-circle-check"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentSelect = document.getElementById('student_id');
            const lecturerSelect = document.getElementById('lecturer_id');

            function handleStudentChange(isInitialLoad = false) {
                const selectedOption = studentSelect.options[studentSelect.selectedIndex];
                if (!selectedOption) return;
                
                const supervisorId = selectedOption.getAttribute('data-supervisor');
                
                // Remove existing hidden input if any
                const existingHidden = document.getElementById('hidden_lecturer_id');
                if (existingHidden) {
                    existingHidden.remove();
                }

                if (supervisorId) {
                    lecturerSelect.value = supervisorId;
                    lecturerSelect.setAttribute('disabled', 'true');
                    
                    // Create hidden input so the value is still submitted in the form
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'lecturer_id';
                    hiddenInput.id = 'hidden_lecturer_id';
                    hiddenInput.value = supervisorId;
                    lecturerSelect.parentNode.appendChild(hiddenInput);
                } else {
                    lecturerSelect.removeAttribute('disabled');
                    if (!isInitialLoad) {
                        lecturerSelect.value = ""; // Reset to default placeholder option
                    }
                }
            }

            studentSelect.addEventListener('change', function () {
                handleStudentChange(false);
            });
            
            // Run on page load in case a student is already pre-selected
            if (studentSelect.value) {
                handleStudentChange(true);
            }
        });
    </script>
</body>
</html>
