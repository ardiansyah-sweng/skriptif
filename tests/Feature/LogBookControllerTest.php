<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\LogBook;

class LogBookControllerTest extends TestCase
{
    use RefreshDatabase;

    private $student;
    private $lecturer;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a student and a lecturer
        $studentId = DB::table('students')->insertGetId([
            'student_id'    => '2200018001',
            'name'          => 'Girhantri',
            'email'         => 'girhantri@webmail.uad.ac.id',
            'year_entrance' => 2023,
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $lecturerId = DB::table('lecturers')->insertGetId([
            'lecturer_id' => '0523048501',
            'name'        => 'Dr. Ahmad Fauzi, M.T.',
            'email'       => 'ahmad.fauzi@tif.uad.ac.id',
            'expertise'   => 'Computer Vision & AI',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('skripsi')->insert([
            'student_id'    => $studentId,
            'supervisor_id' => $lecturerId,
            'title'         => 'Test Skripsi',
            'description'   => 'Test Description',
            'status'        => 'approved',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $this->student = Student::find($studentId);
        $this->lecturer = Lecturer::find($lecturerId);
    }

    public function test_store_log_book_success()
    {
        $response = $this->post('/log-books', [
            'student_id'  => $this->student->id,
            'lecturer_id' => $this->lecturer->id,
            'date'        => '2026-06-23',
            'activity'    => 'Melakukan diskusi mengenai deteksi target objek menggunakan YOLO.',
            'feedback'    => 'Lanjutkan implementasi tracking.',
            'status'      => 'approved',
        ]);

        $response->assertRedirect('/log-books');
        $this->assertDatabaseHas('log_books', [
            'student_id'  => $this->student->id,
            'lecturer_id' => $this->lecturer->id,
            'activity'    => 'Melakukan diskusi mengenai deteksi target objek menggunakan YOLO.',
            'status'      => 'approved',
            'feedback'    => 'Lanjutkan implementasi tracking.',
        ]);
    }

    public function test_update_log_book_success()
    {
        $logBookId = DB::table('log_books')->insertGetId([
            'student_id'  => $this->student->id,
            'lecturer_id' => $this->lecturer->id,
            'date'        => '2026-06-23',
            'activity'    => 'Bimbingan bab 1 pendahuluan.',
            'status'      => 'pending',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $response = $this->put('/log-books/' . $logBookId, [
            'student_id'  => $this->student->id,
            'lecturer_id' => $this->lecturer->id,
            'date'        => '2026-06-23',
            'activity'    => 'Bimbingan bab 1 pendahuluan (revisi).',
            'feedback'    => 'Bab 1 sudah disetujui, lanjut bab 2.',
            'status'      => 'approved',
        ]);

        $response->assertRedirect('/log-books');
        $this->assertDatabaseHas('log_books', [
            'id'       => $logBookId,
            'activity' => 'Bimbingan bab 1 pendahuluan (revisi).',
            'status'   => 'approved',
            'feedback' => 'Bab 1 sudah disetujui, lanjut bab 2.',
        ]);
    }

    public function test_delete_log_book_success()
    {
        $logBookId = DB::table('log_books')->insertGetId([
            'student_id'  => $this->student->id,
            'lecturer_id' => $this->lecturer->id,
            'date'        => '2026-06-23',
            'activity'    => 'Bimbingan bab 1.',
            'status'      => 'pending',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $response = $this->delete('/log-books/' . $logBookId);

        $response->assertRedirect('/log-books');
        $this->assertDatabaseMissing('log_books', [
            'id' => $logBookId,
        ]);
    }
}
