@extends('layouts.app')

@section('title', 'Thesis Submission History — Thesis System')

@push('styles')
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #1a1a2e; padding: 32px 24px; }
        .wrap { max-width: 1000px; margin: 0 auto; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 0.5px solid #e5e7eb; }
        .crumb { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
        .page-head h1 { font-size: 18px; font-weight: 500; }
        .page-head p { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 13px; font-weight: 500; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; }
        th { background-color: #f8fafc; font-weight: 500; color: #374151; border-bottom: 1px solid #e5e7eb; }
        tr { border-bottom: 0.5px solid #e5e7eb; }
        tr:hover { background-color: #f8fafc; }
        
        .status-pending { background-color: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-approved { background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-primary:hover { background: #0C447C; }
        
        @media (max-width: 600px) { body { padding: 16px; } }
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
                    <span>Thesis History</span>
                </div>
                <h1>Thesis Submission History</h1>
                <p>List of all thesis proposals you have submitted</p>
            </div>
            <a href="{{ route('student.skripsi.create') }}" class="btn-primary">
                <i class="ti ti-plus"></i> Submit New Proposal
            </a>
        </div>

        <div class="card">
            <div class="card-title">Submission List</div>

            @if(session('success'))
                <div style="background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:13px;">
                    {{ session('success') == 'Pengajuan berhasil!' ? 'Submission successful!' : session('success') }}
                </div>
            @endif

            @if($skripsis->isEmpty())
                <p style="text-align:center; padding:40px; color:#6b7280;">No thesis submissions found.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Thesis Title</th>
                            <th>Advisor</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skripsis as $skripsi)
                        <tr>
                            <td>{{ $skripsi->title }}</td>
                            <td>
                                @if($skripsi->supervisor)
                                    {{ $skripsi->supervisor->name }}
                                @else
                                    <span style="color:#9ca3af;">Not determined yet</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($skripsi->status) {
                                        'pending' => 'status-pending',
                                        'approved' => 'status-approved',
                                        'rejected' => 'status-rejected',
                                        default => ''
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($skripsi->status) }}</span>
                            </td>
                            <td>{{ $skripsi->submission_date ? $skripsi->submission_date->format('d M Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection