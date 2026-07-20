@extends('layouts.app')

@section('title', 'Unduh Panduan & Template')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
    .content-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
    .card-icon-wrapper { width: 56px; height: 56px; background-color: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
</style>
@endpush

@section('content')
<div style="max-width: 1200px;">
    <div class="mb-4">
        <h1 class="main-title">Repositori Panduan & Template Dokumen</h1>
        <p class="sub-title">Unduh dokumen resmi, buku pedoman, dan template berkas administratif untuk mempermudah penyusunan skripsi Anda.</p>
    </div>

    <div class="row g-4">
        @foreach($templates as $template)
            <div class="col-md-6 col-lg-6">
                <div class="content-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="card-icon-wrapper">
                                <i class="fa-solid {{ $template['icon'] }} fs-3"></i>
                            </div>
                            <span class="badge bg-light text-dark border fw-medium px-3 py-2">{{ $template['type'] }} File</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $template['title'] }}</h5>
                        <p class="text-secondary small mb-3">{{ $template['description'] }}</p>
                    </div>

                    <div class="border-top pt-3 mt-3 d-flex align-items-center justify-content-between">
                        <span class="text-muted small"><i class="fa-solid fa-paperclip me-1"></i> {{ $template['file_name'] }}</span>
                        <a href="{{ route('utilities.repository.download', $template['id']) }}" class="btn btn-primary btn-sm px-3">
                            <i class="fa-solid fa-download me-1"></i> Unduh File
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
