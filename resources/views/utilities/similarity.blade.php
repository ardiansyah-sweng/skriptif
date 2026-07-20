@extends('layouts.app')

@section('title', 'Deteksi Duplikasi Judul')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .progress-bar-custom { height: 8px; border-radius: 4px; }
    .badge-keyword { background-color: #e2e8f0; color: #475569; font-size: 12px; padding: 4px 8px; border-radius: 4px; margin-right: 4px; display: inline-block; }
</style>
@endpush

@section('content')
<div style="max-width: 1200px;">
    <div class="mb-4">
        <h1 class="main-title">Deteksi Duplikasi Judul Skripsi</h1>
        <p class="sub-title">Cek kemiripan ide judul skripsi baru Anda dengan judul-judul skripsi mahasiswa lain yang telah disetujui.</p>
    </div>

    <div class="row">
        <!-- Form Check -->
        <div class="col-md-12 mb-4">
            <div class="content-card p-4">
                <form action="{{ route('utilities.similarity') }}" method="GET">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold text-secondary">Masukkan Usulan Judul Skripsi</label>
                        <textarea class="form-control @error('title') is-invalid @enderror" id="title" name="title" rows="3" placeholder="Contoh: Rancang Bangun Sistem Informasi Manajemen Skripsi Berbasis Web Menggunakan Laravel" required>{{ request('title') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Mulai Analisis Kemiripan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(request()->has('title'))
        <!-- Hasil Analisis -->
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-simple text-primary me-2"></i> Hasil Analisis & Pencocokan</h5>
                    <span class="badge bg-secondary">Ditemukan {{ count($results) }} Kemungkinan Mirip</span>
                </div>

                @if(count($results) > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Judul Skripsi Terdaftar</th>
                                    <th style="width: 25%">Mahasiswa & Pembimbing</th>
                                    <th style="width: 15%">Tingkat Kemiripan</th>
                                    <th style="width: 20%">Kata Kunci Cocok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $item)
                                    @php
                                        $barColor = 'bg-success';
                                        $textColor = 'text-success';
                                        if($item['percent'] >= 60) {
                                            $barColor = 'bg-danger';
                                            $textColor = 'text-danger';
                                        } elseif($item['percent'] >= 40) {
                                            $barColor = 'bg-warning';
                                            $textColor = 'text-warning';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item['skripsi']->title }}</span>
                                            <div class="text-muted small mt-1">{{ Str::limit($item['skripsi']->description, 100) }}</div>
                                        </td>
                                        <td>
                                            <div><strong>{{ $item['skripsi']->student->name ?? 'N/A' }}</strong></div>
                                            <div class="text-secondary small">{{ $item['skripsi']->student->student_id ?? '' }}</div>
                                            <div class="mt-1 small text-muted"><i class="fa-solid fa-chalkboard-user me-1"></i> Pembimbing: {{ $item['skripsi']->supervisor->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ $item['percent'] }}%"></div>
                                                </div>
                                                <span class="fw-bold {{ $textColor }}">{{ $item['percent'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if(count($item['matched_words']) > 0)
                                                @foreach($item['matched_words'] as $word)
                                                    <span class="badge-keyword">{{ $word }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <i class="fa-solid fa-circle-check text-success display-4 mb-3"></i>
                        <h5 class="fw-bold text-success">Judul Skripsi Tergolong Aman!</h5>
                        <p class="text-secondary mb-0">Tidak ditemukan judul skripsi aktif yang memiliki tingkat kemiripan signifikan dengan usulan judul Anda.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
