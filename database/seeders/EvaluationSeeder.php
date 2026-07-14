<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use App\Models\Lecturer;
use App\Models\Skripsi;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        $skripsiList = Skripsi::where('status', 'approved')->get();
        $lecturers = Lecturer::all();

        if ($skripsiList->isEmpty() || $lecturers->isEmpty()) {
            return;
        }

        foreach ($skripsiList as $skripsi) {
            Evaluation::create([
                'skripsi_id' => $skripsi->id,
                'lecturer_id' => $lecturers->random()->id,
                'score' => rand(60, 95),
                'notes' => 'Evaluasi awal (data seeder).',
                'evaluation_date' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}