<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Student</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #1e293b; margin: 32px; }
        .print-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; }
        .print-title { font-size: 20px; font-weight: 700; margin: 0; }
        .print-subtitle { font-size: 12px; color: #64748b; margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; vertical-align: top; }
        th { background-color: #f1f5f9; font-weight: 700; text-transform: uppercase; font-size: 11px; }
        .no-print { display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 16px; }
        .btn-print { background-color: #ef4444; color: #fff; border: none; border-radius: 6px; padding: 8px 18px; font-size: 14px; cursor: pointer; }
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e2e8f0;
            color: #0f172a;
            text-decoration: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 14px;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>

    <body>
        <div class="no-print">
            <a href="{{ route('students.index') }}" class="btn-back">
                ← Kembali ke Data Student
            </a>
            <button type="button" class="btn-print" onclick="window.print()">
                Cetak / Simpan sebagai PDF
            </button>
        </div>

    <div class="print-header">
        <div>
            <h1 class="print-title">Data Student</h1>
            <p class="print-subtitle">Daftar seluruh student terdaftar dalam sistem</p>
        </div>
        <p class="print-subtitle">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">NIM</th>
                <th style="width: 25%">Nama</th>
                <th style="width: 25%">Email</th>
                <th style="width: 15%">Angkatan</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->year_entrance }}</td>
                <td>{{ $student->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data student.</td>
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