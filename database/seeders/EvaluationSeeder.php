<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Lecturer;
use App\Models\Skripsi;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        $skripsi = Skripsi::query()->inRandomOrder()->take(5)->get();
        $lecturers = Lecturer::query()->inRandomOrder()->take(5)->get();

        if ($skripsi->isEmpty() || $lecturers->isEmpty()) {
            return;
        }

        $rows = [];
        foreach ($skripsi as $index => $item) {
            $evaluator = $lecturers->get($index % $lecturers->count());

            $score = [65, 70, 78, 85, 92][$index % 5];

            $rows[] = [
                'skripsi_id' => $item->id,
                'evaluator_id' => $evaluator->id,
                'evaluation_type' => $index % 2 === 0 ? 'Final Defense' : 'Seminar',
                'overall_score' => $score,
                'grade_letter' => $index % 2 === 0 ? 'A' : 'B',
                'revision_notes' => $index % 2 === 0
                    ? 'Sangat memuaskan, perbaiki sedikit typo.'
                    : 'Landasan Teori sudah baik. Perbaiki margin pada Bab 4.',
                'status' => 'passed',
                'evaluation_date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('evaluations')->insert($rows);
    }
}

