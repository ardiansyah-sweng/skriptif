<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Lecturer;

class LogBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('log_books')->truncate();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $girhantri = Student::where('student_id', '2200018001')->first();
        $ricky     = Student::where('student_id', '2200018045')->first();
        $andi      = Student::where('student_id', '2200018099')->first();

        $dosenAi    = Lecturer::where('name', 'like', '%Ahmad Fauzi%')->first();
        $dosenCyber = Lecturer::where('name', 'like', '%Laila Sari%')->first();
        $dosenIot   = Lecturer::where('name', 'like', '%Budi Setiawan%')->first();

        DB::table('log_books')->insert([
            [
                'student_id'  => $girhantri ? $girhantri->id : 1,
                'lecturer_id' => $dosenAi ? $dosenAi->id : 1,
                'date'        => now()->subDays(3)->toDateString(),
                'activity'    => 'Melakukan asistensi bab 1 pendahuluan skripsi tentang pendeteksian objek.',
                'feedback'    => null,
                'status'      => 'pending',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'student_id'  => $ricky ? $ricky->id : 2,
                'lecturer_id' => $dosenCyber ? $dosenCyber->id : 2,
                'date'        => now()->subDays(5)->toDateString(),
                'activity'    => 'Konsultasi metodologi penelitian analisis celah keamanan sql injection.',
                'feedback'    => 'Metodologi sudah tepat, silakan lanjut ke implementasi pengujian dvwa.',
                'status'      => 'approved',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'student_id'  => $andi ? $andi->id : 3,
                'lecturer_id' => $dosenIot ? $dosenIot->id : 3,
                'date'        => now()->subDays(10)->toDateString(),
                'activity'    => 'Diskusi usulan skripsi tentang simulasi finite automata.',
                'feedback'    => 'Topik kurang relevan dengan fokus keilmuan dosen bimbingan.',
                'status'      => 'rejected',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}