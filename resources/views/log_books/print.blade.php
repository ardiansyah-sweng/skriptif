<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Log Book Bimbingan</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #1e293b; margin: 32px; }
        .print-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; }
        .print-title { font-size: 20px; font-weight: 700; margin: 0; }
        .print-subtitle { font-size: 12px; color: #64748b; margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; vertical-align: top; }
        th { background-color: #f1f5f9; font-weight: 700; text-transform: uppercase; font-size: 11px; }
        .no-print { text-align: right; margin-bottom: 16px; }
        .btn-print { background-color: #ef4444; color: #fff; border: none; border-radius: 6px; padding: 8px 18px; font-size: 14px; cursor: pointer; }
        .btn-print:hover { background-color: #dc2626; }
        .badge-status { font-weight: 600; text-transform: uppercase; font-size: 10px; }
        .status-pending { color: #d97706; }
        .status-approved { color: #15803d; }
        .status-rejected { color: #b91c1c; }
        .feedback-box { margin-top: 6px; padding: 6px; background-color: #f8fafc; border-left: 2px solid #3b82f6; font-style: italic; color: #475569; }
        .attachment-thumb { margin-top: 6px; display: block; max-height: 80px; max-width: 120px; border: 1px solid #e2e8f0; border-radius: 4px; }
        .info-table td { border: none; padding: 4px 0; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button type="button" class="btn-print" onclick="window.print()">
            Cetak / Simpan sebagai PDF
        </button>
    </div>

    <!-- Layout Cetak Khusus Per Mahasiswa -->
    <div class="print-header">
        <div>
            <h1 class="print-title">LOG BOOK BIMBINGAN SKRIPSI</h1>
            <p class="print-subtitle">Rekapan catatan konsultasi tugas akhir / skripsi mahasiswa</p>
        </div>
        <p class="print-subtitle">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div style="margin-bottom: 24px;">
        <table class="info-table" style="width: 100%; border: none;">
            <tr>
                <td style="width: 18%; font-weight: bold;">Nama Mahasiswa</td>
                <td style="width: 2%;">:</td>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">NIM</td>
                <td>:</td>
                <td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Judul Skripsi</td>
                <td>:</td>
                <td>{{ $student->skripsi?->title ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Dosen Pembimbing</td>
                <td>:</td>
                <td>{{ $student->skripsi?->supervisor?->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%; text-align: center;">No</th>
                <th style="width: 17%;">Tanggal Bimbingan</th>
                <th style="width: 45%;">Laporan Aktivitas / Progress</th>
                <th style="width: 20%;">Catatan / Feedback Dosen</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logBooks as $index => $log)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $log->date ? $log->date->format('d M Y') : '-' }}</td>
                <td>
                    <div style="white-space: pre-line;">{{ $log->activity }}</div>
                    <!-- Menampilkan gambar bukti bimbingan jika ada berkas yang diunggah -->
                    @if($log->attachment)
                        <div>
                            <img src="{{ asset('storage/' . $log->attachment) }}" class="attachment-thumb" alt="Lampiran">
                        </div>
                    @endif
                </td>
                <td>
                    @if($log->feedback)
                        <div style="white-space: pre-line;">{{ $log->feedback }}</div>
                    @else
                        <span style="color: #94a3b8; font-style: italic;">- Belum ada catatan -</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($log->status == 'pending')
                        <span class="badge-status status-pending">PENDING</span>
                    @elseif($log->status == 'approved')
                        <span class="badge-status status-approved">APPROVED</span>
                    @else
                        <span class="badge-status status-rejected">REJECTED</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada catatan bimbingan untuk mahasiswa ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
