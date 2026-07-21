@extends('layouts.app')

@section('title', 'Plotting Pembimbing')

@push('styles')
<style>
    .main-title { font-size: 24px; font-weight: 700; color: #0f172a; }
    .sub-title { font-size: 14px; color: #64748b; margin-top: 4px; }
    .content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
    .card-header-custom { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 12px; border-top-right-radius: 12px; }
    .table-custom th { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px; }
    .table-custom td { font-size: 14px; color: #334155; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .badge-recommendation { font-size: 12px; padding: 6px 12px; border-radius: 6px; font-weight: 500; }
    .rec-high { background-color: #dcfce7; color: #15803d; }
    .rec-medium { background-color: #e0f2fe; color: #0369a1; }
    .rec-low { background-color: #f1f5f9; color: #475569; }
    .rec-full { background-color: #fee2e2; color: #b91c1c; }
    .badge-keyword { background-color: #dbeafe; color: #1e40af; font-size: 12px; padding: 4px 8px; border-radius: 4px; margin-right: 4px; display: inline-block; }
</style>
@endpush

@section('content')
<div style="max-width: 1200px;">
    <div class="mb-4">
        <h1 class="main-title">Rekomendasi Dosen Pembimbing</h1>
        <p class="sub-title">Cari dosen pembimbing yang memiliki bidang keahlian paling cocok dengan usulan topik skripsi Anda.</p>
    </div>

    <div class="row">
        <!-- Form Check -->
        <div class="col-md-12 mb-4">
            <div class="content-card p-4">
                <form action="{{ route('utilities.supervisor') }}" method="GET">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold text-secondary">Masukkan Topik / Judul Skripsi</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ request('title') }}" placeholder="Contoh: Machine Learning, Web Development, Keamanan Jaringan" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-users-gear me-2"></i> Cari Rekomendasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(request()->has('title'))
        <!-- Hasil Analisis Dosen -->
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users text-primary me-2"></i> Peringkat Rekomendasi Dosen</h5>
                    <span class="badge bg-secondary">Dianalisis dari {{ count($results) }} Dosen</span>
                </div>

                @if(count($results) > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Nama Dosen</th>
                                    <th style="width: 25%">Bidang Keahlian</th>
                                    <th style="width: 20%">Beban Bimbingan Aktif</th>
                                    <th style="width: 25%">Kesesuaian Topik & Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $item)
                                    @php
                                        $recommendationText = 'Kurang Cocok';
                                        $badgeClass = 'rec-low';

                                        if ($item['capacity'] <= 0) {
                                            $recommendationText = 'Kuota Penuh';
                                            $badgeClass = 'rec-full';
                                        } elseif ($item['score'] >= 30) {
                                            $recommendationText = 'Sangat Direkomendasikan';
                                            $badgeClass = 'rec-high';
                                        } elseif ($item['score'] >= 10) {
                                            $recommendationText = 'Direkomendasikan';
                                            $badgeClass = 'rec-medium';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item['lecturer']->name }}</span>
                                            <div class="text-secondary small">{{ $item['lecturer']->lecturer_id }}</div>
                                            <div class="small text-muted">{{ $item['lecturer']->email }}</div>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $item['lecturer']->expertise ?? 'Belum ditentukan' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="fw-bold">{{ $item['active_count'] }} <span class="text-muted">/ {{ $item['lecturer']->max_supervisors ?? 12 }}</span></div>
                                                <span class="text-muted small">(Sisa kuota: {{ $item['capacity'] }})</span>
                                            </div>
                                            <div class="progress mt-1" style="height: 4px; width: 120px;">
                                                @php
                                                    $percentage = ($item['active_count'] / ($item['lecturer']->max_supervisors ?? 12)) * 100;
                                                    $barColor = $percentage >= 100 ? 'bg-danger' : ($percentage >= 75 ? 'bg-warning' : 'bg-primary');
                                                @endphp
                                                <div class="progress-bar {{ $barColor }}" style="width: {{ min($percentage, 100) }}%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <span class="badge-recommendation {{ $badgeClass }}">{{ $recommendationText }}</span>
                                            </div>
                                            @if(count($item['matched_keywords']) > 0)
                                                <div class="mt-1">
                                                    @foreach($item['matched_keywords'] as $keyword)
                                                        <span class="badge-keyword">{{ $keyword }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <i class="fa-solid fa-circle-exclamation text-warning display-4 mb-3"></i>
                        <h5 class="fw-bold">Tidak ada data dosen</h5>
                        <p class="text-secondary mb-0">Silakan tambahkan data dosen terlebih dahulu di menu Akademik.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
