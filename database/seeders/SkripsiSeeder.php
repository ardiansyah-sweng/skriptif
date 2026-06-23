<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Lecturer;

class SkripsiSeeder extends Seeder
{
    public function run(): void
    {
        $girhantri  = Student::where('student_id', '2200018001')->first();
        $ricky      = Student::where('student_id', '2200018045')->first();
        $andi       = Student::where('student_id', '2200018099')->first();

        $dosenAi    = Lecturer::where('expertise', 'like', '%Computer Vision%')->first();
        $dosenCyber = Lecturer::where('expertise', 'like', '%Cyber Security%')->first();

        DB::table('skripsi')->insert([
            [
                'student_id'      => $girhantri->id,
                'supervisor_id'   => $dosenAi ? $dosenAi->id : null,
                'title'           => 'Pengembangan Sistem Target-Locking Pada Pesawat Glider RC Berbasis Computer Vision',
                'description'     => 'Penelitian ini membahas pengembangan sistem target-locking pada pesawat glider RC menggunakan teknologi Computer Vision.',
                'status'          => 'pending',
                'rejection_note'  => null,
                'submission_date' => now()->toDateString(),
                'approval_date'   => null,
                'elective_courses'=> json_encode([['course' => 'PKPL', 'grade' => 'A'], ['course' => 'P. Mobile', 'grade' => 'B']]),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'student_id'      => $ricky->id,
                'supervisor_id'   => $dosenCyber ? $dosenCyber->id : null,
                'title'           => 'Analisis Forensik Jaringan Pada Celah Keamanan SQL Injection Menggunakan DVWA',
                'description'     => 'Penelitian ini menganalisis forensik jaringan pada celah keamanan SQL Injection menggunakan tools DVWA sebagai media pengujian.',
                'status'          => 'approved',
                'rejection_note'  => null,
                'submission_date' => now()->subDays(5)->toDateString(),
                'approval_date'   => now()->subDays(4)->toDateString(),
                'elective_courses'=> json_encode([['course' => 'Keamanan Jaringan', 'grade' => 'A'], ['course' => 'PKPL', 'grade' => 'A']]),
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(4),
            ],
            [
                'student_id'      => $andi->id,
                'supervisor_id'   => null,
                'title'           => 'Implementasi Finite Automata Pada Simulasi Penjualan Sangkar Burung Tradisional',
                'description'     => 'Penelitian ini mengimplementasikan konsep Finite Automata pada simulasi sistem penjualan sangkar burung tradisional berbasis perangkat lunak.',
                'status'          => 'rejected',
                'rejection_note'  => 'Topik kurang relevan dengan bidang keilmuan program studi.',
                'submission_date' => now()->subDays(10)->toDateString(),
                'approval_date'   => null,
                'elective_courses'=> json_encode([['course' => 'P. Mobile', 'grade' => 'B'], ['course' => 'PKPL', 'grade' => 'C']]),
                'created_at'      => now()->subDays(10),
                'updated_at'      => now()->subDays(9),
            ],
        ]);
    }
}