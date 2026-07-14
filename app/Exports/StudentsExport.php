<?php

namespace App\Exports;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected Collection $students;

    public function __construct($students)
    {
        $this->students = $students instanceof Collection ? $students : collect($students);
    }

    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'NIM' => $student->student_id,
                'Nama' => $student->name,
                'Email' => $student->email,
                'Angkatan' => $student->year_entrance,
                'Program Studi' => $student->study_program,
                'Status Mahasiswa' => $student->status,
                'Status Skripsi' => optional($student->skripsi)->status,
                'Dosen Pembimbing' => optional(optional($student->skripsi)->supervisor)->name,
                'Tanggal Pengajuan' => optional($student->skripsi)->submission_date,
                'Tanggal Approval' => optional($student->skripsi)->approval_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Email',
            'Angkatan',
            'Program Studi',
            'Status Mahasiswa',
            'Status Skripsi',
            'Dosen Pembimbing',
            'Tanggal Pengajuan',
            'Tanggal Approval',
        ];
    }
}
