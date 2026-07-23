@extends('layouts.app')

@section('title', 'Detail Evaluasi')

@push('styles')
<style>
    .wrap-eval { max-width: 720px; margin: 0 auto; }

    .page-head { margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; }
    .page-head h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
    .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }

    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 4px;
    }
    .role-pembimbing { background: #E6F1FB; color: #0C447C; }
    .role-penguji { background: #FFF6E0; color: #A66A00; }

    .grade-badge-lg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 700;
    }
    .grade-A { background: #E6F7EE; color: #16794A; }
    .grade-B { background: #E6F1FB; color: #0C447C; }
    .grade-C { background: #FFF6E0; color: #A66A00; }
    .grade-D { background: #FCEBEB; color: #A32D2D; }
    .grade-E { background: #F3E8FD; color: #6B21A8; }

    .card-eval {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 16px;
    }

    .card-title-eval {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .kv-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px 20px;
    }
    .kv-item .label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }
    .kv-item .val {
        font-size: 13.5px;
        color: #1a1a2e;
        font-weight: 500;
    }

    .score-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9fafb;
        border: 0.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 20px;
    }
    .score-big {
        font-size: 28px;
        font-weight: 700;
        color: #185FA5;
        line-height: 1;
    }
    .score-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    .comp-table { width: 100%; border-collapse: collapse; font-size: 13px; margin: 0; }
    .comp-table thead th {
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 500;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .05em;
        border-bottom: 0.5px solid #e5e7eb;
        text-align: left;
    }
    .comp-table tbody tr { border-bottom: 0.5px solid #f0f0f0; }
    .comp-table tbody tr:last-child { border-bottom: none; }
    .comp-table tbody td { padding: 10px 12px; vertical-align: middle; }

    .rekap-card {
        background: #E6F1FB;
        border: 0.5px solid #B5D4F4;
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 16px;
    }
    .rekap-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
        align-items: center;
    }
    .rekap-item .label { font-size: 11px; color: #0C447C; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px; }
    .rekap-item .val { font-size: 14px; color: #0C447C; font-weight: 600; }
    .rekap-total { font-size: 24px; font-weight: 700; color: #185FA5; }

    .actions { display: flex; gap: 8px; margin-top: 20px; }
    .btn-edit-custom {
        padding: 9px 18px;
        background: #185FA5;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
        font-weight: 500;
    }
    .btn-edit-custom:hover { background: #0C447C; color: #fff; }
    .btn-cancel {
        padding: 9px 18px;
        background: transparent;
        border: 0.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        color: #6b7280;
        text-decoration: none;
    }
    .btn-cancel:hover { background: #f4f6f9; }
</style>
@endpush

@section('content')
<div class="wrap-eval">
    <div class="page-head">
        <div>
            <h1>Detail Evaluasi Skripsi</h1>
            <span class="role-badge role-{{ $evaluation->role }}">
                {{ $evaluation->role === 'pembimbing' ? 'Rubrik Dosen Pembimbing' : 'Rubrik Dosen Penguji' }}
            </span>
        </div>
        <div class="grade-badge-lg grade-{{ $evaluation->grade }}" title="Grade {{ $evaluation->grade }}">
            {{ $evaluation->grade }}
        </div>
    </div>

    <div class="card-eval">
        <div class="card-title-eval"><i class="ti ti-user-check"></i> Identitas Skripsi &amp; Penilai</div>
        <div class="kv-grid">
            <div class="kv-item">
                <div class="label">Mahasiswa</div>
                <div class="val">{{ $evaluation->skripsi->student->name ?? '-' }}</div>
            </div>
            <div class="kv-item">
                <div class="label">NIM</div>
                <div class="val">{{ $evaluation->skripsi->student->nim ?? '-' }}</div>
            </div>
            <div class="kv-item" style="grid-column: span 2">
                <div class="label">Judul Skripsi</div>
                <div class="val">{{ $evaluation->skripsi->title ?? '-' }}</div>
            </div>
            <div class="kv-item">
                <div class="label">Dosen Penilai</div>
                <div class="val">{{ $evaluation->lecturer->name ?? '-' }}</div>
            </div>
            <div class="kv-item">
                <div class="label">Tanggal Evaluasi</div>
                <div class="val">{{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d F Y') }}</div>
            </div>
        </div>
    </div>

    <div class="card-eval">
        <div class="card-title-eval"><i class="ti ti-calculator"></i> Ringkasan Nilai</div>
        <div class="score-summary">
            <div>
                <div class="score-big">{{ number_format($evaluation->score, 1) }}</div>
                <div class="score-label">Total Nilai Peran (0 - 100)</div>
            </div>
            <div style="text-align:right">
                <div class="score-big" style="font-size:22px; color:#374151">× {{ number_format($evaluation->weight, 0) }}%</div>
                <div class="score-label">Bobot Peran Penilai</div>
            </div>
            <div style="text-align:right">
                <div class="score-big" style="color:#16794A">{{ number_format($evaluation->final_score, 1) }}</div>
                <div class="score-label">Kontribusi Nilai Akhir</div>
            </div>
        </div>
    </div>

    <div class="card-eval">
        <div class="card-title-eval"><i class="ti ti-list-check"></i> Rincian Per Unsur Penilaian</div>
        @if($evaluation->componentScores->isEmpty())
            <p style="font-size:13px; color:#9ca3af; text-align:center; padding:12px 0">Tidak ada rincian unsur penilaian tersimpan.</p>
        @else
            <table class="comp-table">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Unsur Penilaian</th>
                        <th style="width:90px; text-align:right">Rentang</th>
                        <th style="width:80px; text-align:right">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluation->componentScores as $index => $cs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cs->component->name ?? 'Unsur #' . $cs->evaluation_component_id }}</td>
                            <td style="text-align:right; color:#9ca3af; font-size:11px">
                                {{ $cs->component ? rtrim(rtrim($cs->component->min_score, '0'), '.') . ' - ' . rtrim(rtrim($cs->component->max_score, '0'), '.') : '-' }}
                            </td>
                            <td style="text-align:right; font-weight:600; color:#185FA5">
                                {{ number_format($cs->score, 1) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if($evaluation->notes)
        <div class="card-eval">
            <div class="card-title-eval"><i class="ti ti-note"></i> Catatan Dosen</div>
            <p style="font-size:13px; color:#374151; white-space:pre-wrap; margin:0">{{ $evaluation->notes }}</p>
        </div>
    @endif

    <div class="rekap-card">
        <div class="rekap-grid">
            <div class="rekap-item">
                <div class="label">Nilai Pembimbing (50%)</div>
                <div class="val">
                    @if($evaluation->role === 'pembimbing')
                        {{ number_format($evaluation->final_score, 1) }}
                    @elseif($counterpart)
                        {{ number_format($counterpart->final_score, 1) }}
                    @else
                        <span style="color:#9ca3af; font-weight:normal">Belum diisi</span>
                    @endif
                </div>
            </div>
            <div class="rekap-item">
                <div class="label">Nilai Penguji (50%)</div>
                <div class="val">
                    @if($evaluation->role === 'penguji')
                        {{ number_format($evaluation->final_score, 1) }}
                    @elseif($counterpart)
                        {{ number_format($counterpart->final_score, 1) }}
                    @else
                        <span style="color:#9ca3af; font-weight:normal">Belum diisi</span>
                    @endif
                </div>
            </div>
            <div class="rekap-item" style="text-align:right">
                <div class="label">Total Nilai Sempro</div>
                <div class="rekap-total">
                    @php
                        $p = $evaluation->role === 'pembimbing' ? $evaluation->final_score : ($counterpart ? $counterpart->final_score : 0);
                        $q = $evaluation->role === 'penguji' ? $evaluation->final_score : ($counterpart ? $counterpart->final_score : 0);
                    @endphp
                    {{ number_format($p + $q, 1) }}
                </div>
            </div>
        </div>
    </div>

    <div class="actions">
        <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn-edit-custom">Edit Evaluasi</a>
        <a href="{{ route('evaluations.index') }}" class="btn-cancel">Kembali</a>
    </div>
</div>
@endsection