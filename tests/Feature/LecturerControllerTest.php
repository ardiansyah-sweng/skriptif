<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createLecturer(array $override = []): int
    {
        return DB::table('lecturers')->insertGetId(array_merge([
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi',
            'email'       => 'ahmad.fauzi@uad.ac.id',
            'expertise'   => 'Rekayasa Perangkat Lunak',
            'created_at'  => now(),
            'updated_at'  => now(),
        ], $override));
    }

    public function test_store_lecturer_success()
    {
        $response = $this->post('/lecturers', [
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi',
            'email'       => 'ahmad.fauzi@uad.ac.id',
            'expertise'   => 'Rekayasa Perangkat Lunak',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('lecturers', [
            'lecturer_id' => 'LCT001',
            'email'       => 'ahmad.fauzi@uad.ac.id',
        ]);
    }

    public function test_delete_lecturer_success()
    {
        $id = $this->createLecturer();

        $response = $this->delete('/lecturers/' . $id);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('lecturers', [
            'id' => $id,
        ]);
    }
}