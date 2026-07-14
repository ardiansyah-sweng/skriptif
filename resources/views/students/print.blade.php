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

</html>