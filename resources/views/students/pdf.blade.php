<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Data Mahasiswa</title>

    <style>
        {!! file_get_contents(public_path('css/pdf.css')) !!}
    </style>

</head>

<body>

    <div class="header">

        <h1>SISTEM INFORMASI SKRIPSI</h1>

        <h3>Laporan Data Mahasiswa</h3>

        <p>Universitas Ahmad Dahlan</p>

        <p>Tanggal Cetak :
            {{ now()->format('d F Y H:i') }}
        </p>

        <div class="line"></div>

    </div>

    <table>

        <thead>

            <tr>

                <th width="6%">No</th>

                <th width="18%">NIM</th>

                <th>Nama Mahasiswa</th>

                <th>Email</th>

                <th width="20%">Program Studi</th>

            </tr>

        </thead>

        <tbody>

            @foreach($students as $student)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $student->student_id }}
                    </td>

                    <td>
                        {{ $student->name }}
                    </td>

                    <td>
                        {{ $student->email }}
                    </td>

                    <td>
                        {{ $student->study_program }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="footer">

        <table width="100%">

            <tr>

                <td></td>

                <td class="signature">

                    Yogyakarta,
                    {{ now()->format('d F Y') }}

                    <br><br>

                    Administrator

                    <div class="signature-space"></div>

                    ______________________

                </td>

            </tr>

        </table>

    </div>

    <div class="generated">

        Dicetak otomatis oleh Sistem Informasi Skripsi

    </div>

</body>

</html>