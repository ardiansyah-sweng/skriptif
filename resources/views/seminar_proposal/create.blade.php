@extends('layouts.app')

@section('title', 'Upload Berkas Seminar Proposal')

@push('styles')
<style>
    .wrap { max-width: 900px; }
    .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
    .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
    .page-head h1 { font-size: 18px; font-weight: 500; margin: 0; }
    .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
    .wrap .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
    .wrap .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
    .empty-state { text-align: center; padding: 40px; color: #6b7280; font-size: 13px; }

    .checklist { display: flex; flex-direction: column; gap: 10px; }
    .checklist-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border: 0.5px solid #e5e7eb; border-radius: 8px; }
    .checklist-item .label { display: flex; align-items: center; gap: 10px; font-size: 13px; }
    .checklist-item .label i { font-size: 16px; }
    .status-uploaded { background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
    .status-missing { background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
    .file-link { font-size: 12px; color: #185FA5; text-decoration: none; margin-right: 10px; }
    .file-link:hover { text-decoration: underline; }

    .sp-form-group { margin-bottom: 16px; }
    .sp-form-group label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; }
    .sp-form-group input[type="file"], .sp-form-group input[type="text"], .sp-form-group select {
        width: 100%; padding: 9px 12px; border: 0.5px solid #d1d5db; border-radius: 8px;
        font-size: 13px; font-family: inherit; color: #1a1a2e; background: #fff; outline: none;
    }
    .sp-form-group input:focus, .sp-form-group select:focus { border-color: #185FA5; }
    .sp-form-group input[disabled] { background: #f3f4f6; color: #6b7280; cursor: not-allowed; }
    .form-hint { font-size: 12px; color: #9ca3af; margin-top: 5px; display: block; }
    .form-error { font-size: 12px; color: #A32D2D; margin-top: 5px; display: block; }

    .btn-primary-sp { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
    .btn-primary-sp:hover { background: #0C447C; }
    .btn-secondary-link { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: transparent; color: #1a1a2e; border: 0.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
    .btn-secondary-link:hover { background: #f9fafb; }
</style>
@endpush

@section('content')
    <div class="wrap">
        <div class="page-head">
            <div>
                <div class="crumb">
                    <i class="ti ti-home" style="font-size:11px"></i>
                    <span>Home</span>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <a href="{{ url()->previous() }}" style="color:#9ca3af; text-decoration:none;">Seminar Proposal</a>
                    <i class="ti ti-chevron-right" style="font-size:11px"></i>
                    <span>Upload Berkas</span>
                </div>
                <h1>Upload Berkas Seminar Proposal</h1>
                <p>Pilih mahasiswa lalu unggah kelengkapan berkas sebagai syarat pengajuan seminar proposal</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn-secondary-link">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>


        @if(!$student)
            <div class="card">
                <div class="empty-state">Pilih mahasiswa terlebih dahulu untuk melihat kelengkapan berkas.</div>
            </div>
        @elseif(!$skripsi)
            <div class="card">
                <div class="empty-state">Mahasiswa ini belum memiliki pengajuan skripsi.</div>
            </div>
        @else
            <div class="card">
                <div class="card-title">Informasi Mahasiswa & Skripsi</div>
                <div class="sp-form-group">
                    <label for="student_name">Nama Mahasiswa</label>
                    <input type="text" id="student_name" value="{{ $student->name }}" disabled>
                </div>
                <div class="sp-form-group">
                    <label for="supervisor_name">Dosen Pembimbing</label>
                    <input type="text" id="supervisor_name" value="{{ $skripsi->supervisor->name ?? 'Belum ditentukan' }}" disabled>
                </div>
                <div class="sp-form-group" style="margin-bottom:0;">
                    <label for="skripsi_title">Judul Skripsi</label>
                    <input type="text" id="skripsi_title" value="{{ $skripsi->title }}" disabled>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Status Kelengkapan Berkas</div>
                <div class="checklist">
                    @foreach($documentFields as $field => $label)
                        <div class="checklist-item">
                            <div class="label">
                                @if($document && $document->$field)
                                    <i class="ti ti-circle-check" style="color:#065f46"></i>
                                @else
                                    <i class="ti ti-circle-x" style="color:#991b1b"></i>
                                @endif
                                <span>{{ $label }}</span>
                            </div>
                            <div>
                                @if($document && $document->$field)
                                    <a href="{{ asset('storage/' . $document->$field) }}" target="_blank" class="file-link">Lihat berkas</a>
                                    <span class="status-uploaded">Sudah diunggah</span>
                                @else
                                    <span class="status-missing">Belum diunggah</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('seminar-proposal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div class="card">
                    <div class="card-title">Unggah / Perbarui Berkas</div>

                    @foreach($documentFields as $field => $label)
                        <div class="sp-form-group">
                            <label for="{{ $field }}">{{ $label }}</label>
                            <input type="file" id="{{ $field }}" name="{{ $field }}" accept="application/pdf,image/*">
                            <span class="form-hint">Format pdf, jpg, jpeg, atau png. Maksimal 2MB.</span>
                            @error($field)
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div style="display:flex;gap:8px; margin-top: 20px;">
                    <button type="submit" class="btn-primary-sp">
                        <i class="ti ti-upload"></i> Simpan Berkas
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection
