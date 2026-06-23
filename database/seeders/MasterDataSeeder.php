<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('skripsi')->truncate();
        DB::table('lecturers')->truncate();
        DB::table('students')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Lecturers
        DB::table('lecturers')->insert([
            [
                'lecturer_id' => '0523048501',
                'name'        => 'Dr. Ahmad Fauzi, M.T.',
                'email'       => 'ahmad.fauzi@tif.uad.ac.id',
                'expertise'   => 'Computer Vision & AI',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'lecturer_id' => '0512098802',
                'name'        => 'Laila Sari, M.Cs.',
                'email'       => 'laila.sari@tif.uad.ac.id',
                'expertise'   => 'Cyber Security & Forensics',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'lecturer_id' => '0531019003',
                'name'        => 'Budi Setiawan, Ph.D.',
                'email'       => 'budi.setiawan@tif.uad.ac.id',
                'expertise'   => 'Embedded Systems & IoT',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // 2. Students
        DB::table('students')->insert([
            [
                'student_id'    => '2200018001',
                'name'          => 'Girhantri',
                'email'         => 'girhantri@webmail.uad.ac.id',
                'year_entrance' => 2023,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'student_id'    => '2200018045',
                'name'          => 'Ricky Sugara',
                'email'         => 'ricky.sugara@webmail.uad.ac.id',
                'year_entrance' => 2023,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'student_id'    => '2200018099',
                'name'          => 'Andi Pratama',
                'email'         => 'andi.pratama@webmail.uad.ac.id',
                'year_entrance' => 2023,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}