<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Dosen</title>
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

    <div class="print-header">
        <div>
            <h1 class="print-title">Data Dosen</h1>
            <p class="print-subtitle">Daftar seluruh dosen terdaftar dalam sistem</p>
        </div>
        <p class="print-subtitle">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 13%">ID Dosen</th>
                <th style="width: 22%">Nama</th>
                <th style="width: 22%">Email</th>
                <th style="width: 26%">Keahlian</th>
                <th style="width: 12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lecturers as $index => $lecturer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lecturer->lecturer_id }}</td>
                <td>{{ $lecturer->name }}</td>
                <td>{{ $lecturer->email }}</td>
                <td>{{ $lecturer->expertise ?? '-' }}</td>
                <td>{{ ucfirst($lecturer->status ?? 'aktif') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data dosen.</td>
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
