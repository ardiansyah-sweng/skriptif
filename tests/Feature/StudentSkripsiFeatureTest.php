<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StudentSkripsiFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $override = [])
    {
        return DB::table('students')->insertGetId(array_merge([
            'student_id'    => 'STU-001',
            'name'          => 'Test Mahasiswa',
            'email'         => 'student@example.test',
            'year_entrance' => 2022,
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ], $override));
    }

    private function createLecturer(array $override = [])
    {
        return DB::table('lecturers')->insertGetId(array_merge([
            'lecturer_id' => 'LCT-001',
            'name'        => 'Dr. Dosen',
            'email'       => 'dosen@example.test',
            'expertise'   => 'Sistem Informasi',
            'max_supervisors' => 3,
            'created_at'  => now(),
            'updated_at'  => now(),
        ], $override));
    }

    public function test_index_displays_skripsis()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();

        DB::table('skripsi')->insert([
            'student_id' => $studentId,
            'supervisor_id' => $lecturerId,
            'title' => 'Skripsi Test',
            'description' => 'Deskripsi',
            'status' => 'pending',
            'submission_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/student/skripsi');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.skripsi.index');
        $response->assertViewHas('skripsis');
    }

    public function test_show_displays_skripsi_detail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();

        $id = DB::table('skripsi')->insertGetId([
            'student_id' => $studentId,
            'supervisor_id' => $lecturerId,
            'title' => 'Skripsi Detail',
            'description' => 'Detail description',
            'status' => 'pending',
            'submission_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/student/skripsi/'.$id);

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.skripsi.index');
        $response->assertViewHas('skripsi');
    }

    public function test_update_changes_skripsi()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();
        $newLecturerId = $this->createLecturer(['lecturer_id' => 'LCT-002', 'name' => 'Dr. Baru', 'email' => 'baru@example.test']);

        $id = DB::table('skripsi')->insertGetId([
            'student_id' => $studentId,
            'supervisor_id' => $lecturerId,
            'title' => 'Old Title',
            'description' => 'Old',
            'status' => 'pending',
            'submission_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->put('/student/skripsi/'.$id, [
            'title' => 'New Title',
            'description' => 'New description',
            'supervisor_id' => $newLecturerId,
        ]);

        $response->assertRedirect('/student/skripsi/'.$id);

        $this->assertDatabaseHas('skripsi', [
            'id' => $id,
            'title' => 'New Title',
            'description' => 'New description',
            'supervisor_id' => $newLecturerId,
        ]);
    }
}
