<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LogbookTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Schema::disableForeignKeyConstraints();
    }

    public function test_can_store_new_logbook()
    {
        $this->withoutExceptionHandling();

        $evaluatorId = DB::table('lecturers')->insertGetId([
            'lecturer_id' => 'L' . rand(1000, 9999),
            'name' => 'Dosen Penguji',
            'email' => 'penguji_' . rand(1, 9999) . '@kampus.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id' => 99,
            'title' => 'Sistem Analisis Sentimen',
            'description' => 'Deskripsi skripsi testing',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'skripsi_id' => $skripsiId,
            'evaluator_id' => $evaluatorId,
            'logbook_type' => 'Final Defense',
            'overall_score' => 85,
            'grade_letter' => 'A',
            'revision_notes' => 'Sangat memuaskan, perbaiki sedikit typo.',
            'status' => 'passed',
            'logbook_date' => now()->toDateString(),
        ];

        $response = $this->post(route('logbooks.store'), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('logbooks.index'));

        $this->assertDatabaseHas('logbooks', [
            'skripsi_id' => $skripsiId,
            'evaluator_id' => $evaluatorId,
            'overall_score' => 85,
        ]);
    }

    public function test_cannot_store_logbook_with_score_above_100()
    {
        $evaluatorId = DB::table('lecturers')->insertGetId([
            'lecturer_id' => 'L' . rand(1000, 9999),
            'name' => 'Dosen Penguji Dua',
            'email' => 'penguji2_' . rand(1, 9999) . '@kampus.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id' => 88,
            'title' => 'Skripsi Testing Dua',
            'description' => 'Deskripsi skripsi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'skripsi_id' => $skripsiId,
            'evaluator_id' => $evaluatorId,
            'logbook_type' => 'Seminar',
            'overall_score' => 150,
            'logbook_date' => now()->toDateString(),
        ];

        $response = $this->post(route('logbooks.store'), $payload);

        $response->assertSessionHasErrors('overall_score');

        $this->assertDatabaseMissing('logbooks', [
            'overall_score' => 150,
        ]);
    }
}