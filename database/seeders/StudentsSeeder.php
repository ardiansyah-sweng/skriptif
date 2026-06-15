<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'student_id'    => '2021001',
                'name'          => 'Ahmad Rizki Pratama',
                'email'         => 'ahmad.rizki@student.uad.ac.id',
                'year_entrance' => 2021,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2021002',
                'name'          => 'Siti Nurhaliza',
                'email'         => 'siti.nurhaliza@student.uad.ac.id',
                'year_entrance' => 2021,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2021003',
                'name'          => 'Budi Santoso',
                'email'         => 'budi.santoso@student.uad.ac.id',
                'year_entrance' => 2021,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2021004',
                'name'          => 'Rina Handayani',
                'email'         => 'rina.handayani@student.uad.ac.id',
                'year_entrance' => 2021,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2021005',
                'name'          => 'Doni Wijaya',
                'email'         => 'doni.wijaya@student.uad.ac.id',
                'year_entrance' => 2021,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2022001',
                'name'          => 'Erika Susanti',
                'email'         => 'erika.susanti@student.uad.ac.id',
                'year_entrance' => 2022,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2022002',
                'name'          => 'Fahri Irawan',
                'email'         => 'fahri.irawan@student.uad.ac.id',
                'year_entrance' => 2022,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2022003',
                'name'          => 'Gita Mahendra',
                'email'         => 'gita.mahendra@student.uad.ac.id',
                'year_entrance' => 2022,
                'status'        => 'active',
            ],
            [
                'student_id'    => '2022004',
                'name'          => 'Hendra Kusuma',
                'email'         => 'hendra.kusuma@student.uad.ac.id',
                'year_entrance' => 2022,
                'status'        => 'inactive',
            ],
            [
                'student_id'    => '2022005',
                'name'          => 'Indah Lestari',
                'email'         => 'indah.lestari@student.uad.ac.id',
                'year_entrance' => 2022,
                'status'        => 'active',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
