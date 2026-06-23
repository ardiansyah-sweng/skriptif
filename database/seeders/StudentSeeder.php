<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'student_id' => 'STU-2026-001',
                'name' => 'Alya Putri',
                'email' => 'alya.putri@example.com',
                'year_entrance' => 2023,
                'status' => 'active',
            ],
            [
                'student_id' => 'STU-2026-002',
                'name' => 'Bagas Pratama',
                'email' => 'bagas.pratama@example.com',
                'year_entrance' => 2022,
                'status' => 'active',
            ],
            [
                'student_id' => 'STU-2026-003',
                'name' => 'Citra Lestari',
                'email' => 'citra.lestari@example.com',
                'year_entrance' => 2023,
                'status' => 'inactive',
            ],
            [
                'student_id' => 'STU-2026-004',
                'name' => 'Dimas Saputra',
                'email' => 'dimas.saputra@example.com',
                'year_entrance' => 2024,
                'status' => 'active',
            ],
            [
                'student_id' => 'STU-2026-005',
                'name' => 'Eka Nabila',
                'email' => 'eka.nabila@example.com',
                'year_entrance' => 2021,
                'status' => 'active',
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['student_id' => $student['student_id']],
                $student
            );
        }
    }
}