<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ElectiveCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            'Rekayasa Perangkat Lunak',
            'Pemrograman Mobile',
            'Kecerdasan Buatan',
            'Keamanan Jaringan Komputer',
            'Pengolahan Citra Digital',
            'Sistem Terdistribusi',
            'Analisis dan Perancangan Perangkat Lunak',
        ];

        foreach ($courses as $course) {
            DB::table('elective_courses')->insert([
                'courses'   => $course,
                'timestamp' => Carbon::now(),
            ]);
        }
    }
}