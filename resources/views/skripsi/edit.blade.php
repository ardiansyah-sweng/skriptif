<!DOCTYPE html>

<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan Skripsi</title>


    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    }

    .content-card {
      background: white;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    }

    .card-header-custom {
      padding: 20px 24px;
      border-bottom: 1px solid #e2e8f0;
    }

    .card-body-custom {
      padding: 24px;
    }

    label {
      font-size: 13px;
      font-weight: 600;
      color: #475569;
      margin-bottom: 6px;
    }

    .readonly-box {
      background-color: #f8fafc;
    }
    </style>


  </head>

  <body>

    <div class="container py-5" style="max-width: 900px;">


      <div class="mb-4">
        <h1 class="main-title">Edit Pengajuan Skripsi</h1>
        <p class="sub-title">
          Tentukan dosen pembimbing dan status pengajuan skripsi.
        </p>
      </div>

      <div class="content-card">

        <div class="card-header-custom">
          <strong>Data Pengajuan Skripsi</strong>
        </div>

        <div class="card-body-custom">

          <form action="{{ route('skripsi.update', $skripsi->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
              <label>Mahasiswa</label>
              <input type="text" class="form-control readonly-box" value="{{ $skripsi->student->name }}" readonly>
            </div>

            <div class="mb-3">
              <label>Judul Skripsi</label>
              <input type="text" class="form-control readonly-box" value="{{ $skripsi->title }}" readonly>
            </div>

            <div class="mb-3">
              <label>Deskripsi</label>
              <textarea class="form-control readonly-box" rows="4" readonly>{{ $skripsi->description }}</textarea>
            </div>

            <div class="mb-3">
              <label>Dosen Usulan Mahasiswa</label>

              <input type="text" class="form-control readonly-box"
                value="{{ $skripsi->suggestionSupervisor->name ?? '-' }}" readonly>
            </div>

            <div class="mb-3">
              <label>Dosen Pembimbing</label>

              <select name="supervisor_id" class="form-select">

                <option value="">
                  -- Pilih Dosen Pembimbing --
                </option>

                @foreach($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}" {{ $skripsi->supervisor_id == $lecturer->id ? 'selected' : '' }}>
                  {{ $lecturer->name }}
                </option>
                @endforeach

              </select>

              @error('supervisor_id')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>

            <div class="mb-3">
              <label>Status Pengajuan</label>

              <select name="status" class="form-select">

                <option value="pending" {{ $skripsi->status == 'pending' ? 'selected' : '' }}>
                  Pending
                </option>

                <option value="approved" {{ $skripsi->status == 'approved' ? 'selected' : '' }}>
                  Disetujui
                </option>

                <option value="rejected" {{ $skripsi->status == 'rejected' ? 'selected' : '' }}>
                  Ditolak
                </option>

              </select>
            </div>

            <div class="mb-4">
              <label>Catatan Penolakan</label>

              <textarea name="rejection_note" class="form-control" rows="4"
                placeholder="Isi jika pengajuan ditolak...">{{ old('rejection_note', $skripsi->rejection_note) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">

              <a href="{{ route('skripsi.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
              </a>

              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Perubahan
              </button>

            </div>

          </form>

        </div>

      </div>


    </div>

  </body>

</html>