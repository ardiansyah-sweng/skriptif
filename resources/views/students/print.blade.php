<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mahasiswa</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        table th {
            background: #eeeeee;
        }
    </style>
</head>

<body>

    <h2>LAPORAN DATA MAHASASISWA</h2>

    @if(!empty($appliedFilters) && array_filter($appliedFilters))
        <div style="margin-bottom:16px; padding:12px; border:1px solid #000; border-radius:8px; background:#f7f7f7;">
            <strong>Filter terapkan:</strong>
            <ul style="margin:8px 0 0 18px; padding:0; list-style: disc;">
                @if(!empty($appliedFilters['status']))
                    <li>Status Mahasiswa: {{ $appliedFilters['status'] }}</li>
                @endif
                @if(!empty($appliedFilters['study_program']))
                    <li>Program Studi: {{ $appliedFilters['study_program'] }}</li>
                @endif
                @if(!empty($appliedFilters['year_entrance']))
                    <li>Tahun Masuk: {{ $appliedFilters['year_entrance'] }}</li>
                @endif
                @if(!empty($appliedFilters['search_field']) && !empty($appliedFilters['search_value']))
                    <li>{{ ucfirst(str_replace('_', ' ', $appliedFilters['search_field'])) }} berisi: {{ $appliedFilters['search_value'] }}</li>
                @endif
                @if(!empty($appliedFilters['skripsi_status']))
                    <li>Status Skripsi: {{ $appliedFilters['skripsi_status'] }}</li>
                @endif
                @if(!empty($appliedFilters['supervisor_name']))
                    <li>Dosen Pembimbing: {{ $appliedFilters['supervisor_name'] }}</li>
                @endif
                @if(!empty($appliedFilters['graduated']))
                    <li>Mahasiswa Lulus Sidang</li>
                @endif
                @if(!empty($appliedFilters['date_field']))
                    <li>Rentang Tanggal {{ ucfirst(str_replace('_', ' ', $appliedFilters['date_field'])) }}: {{ $appliedFilters['date_start'] ?? '-' }} s/d {{ $appliedFilters['date_end'] ?? '-' }}</li>
                @endif
            </ul>
        </div>
    @endif
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
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tahun Masuk</th>
                <th>Program Studi</th>
                <th>Status</th>
                <th>Status Skripsi</th>
                <th>Dosen Pembimbing</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Approval</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->year_entrance }}</td>
                    <td>{{ $student->study_program }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ optional($student->skripsi)->status }}</td>
                    <td>{{ optional(optional($student->skripsi)->supervisor)->name }}</td>
                    <td>{{ optional($student->skripsi)->submission_date }}</td>
                    <td>{{ optional($student->skripsi)->approval_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

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