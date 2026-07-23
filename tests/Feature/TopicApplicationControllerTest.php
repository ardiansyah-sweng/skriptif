<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TopicApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createLecturer(array $override = []): int
    {
        return DB::table('lecturers')->insertGetId(array_merge([
            'lecturer_id' => 'LCT001',
            'name' => 'Dr. Siti Aisyah',
            'email' => 'siti.aisyah@uad.ac.id',
            'expertise' => 'Sistem Informasi',
            'created_at' => now(),
            'updated_at' => now(),
        ], $override));
    }

    private function createLecturerTopic(int $lecturerId, array $override = []): int
    {
        return DB::table('lecturer_topics')->insertGetId(array_merge([
            'lecturer_id' => $lecturerId,
            'title' => 'Topik Pengembangan Sistem Informasi',
            'description' => 'Topik ini cocok untuk mahasiswa yang ingin membangun aplikasi manajemen data.',
            'requirements' => "Buat proposal, lampirkan CV, dan jelaskan latar belakang masalah.",
            'status' => 'open',
            'capacity' => 2,
            'applied_count' => 0,
            'deadline' => now()->addWeeks(2)->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ], $override));
    }

    public function test_topic_board_show_displays_topic_and_apply_form()
    {
        $lecturerId = $this->createLecturer();
        $topicId = $this->createLecturerTopic($lecturerId);

        $response = $this->get(route('topic-board.show', $topicId));

        $response->assertStatus(200);
        $response->assertSee('Ajukan Diri');
        $response->assertSee('Nama Mahasiswa');
        $response->assertSee('Pesan / Catatan');
    }

    public function test_student_can_apply_with_document_upload()
    {
        $lecturerId = $this->createLecturer();
        $topicId = $this->createLecturerTopic($lecturerId);

        $studentId = DB::table('students')->insertGetId([
            'student_id' => 'NIM12345',
            'name' => 'Dewi Rahma',
            'email' => 'dewi.rahma@uad.ac.id',
            'year_entrance' => 2023,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $response = $this->post(route('topic-board.apply', $topicId), [
            'student_id' => $studentId,
            'message' => 'Saya tertarik dengan topik ini.',
        ]);

        $response->assertRedirect(route('topic-board.show', $topicId));
        $response->assertSessionHas('success', 'Pengajuan topik berhasil dikirim.');
        $this->assertDatabaseHas('topic_applications', [
            'lecturer_topic_id' => $topicId,
            'student_id' => $studentId,
            'message' => 'Saya tertarik dengan topik ini.',
            'status' => 'pending',
        ]);
    }

    public function test_approve_application_changes_status_to_approved()
    {
        $lecturerId = $this->createLecturer();
        $topicId = $this->createLecturerTopic($lecturerId);
        $studentId = DB::table('students')->insertGetId([
            'student_id' => 'NIM12345',
            'name' => 'Dewi Rahma',
            'email' => 'dewi.rahma@uad.ac.id',
            'year_entrance' => 2023,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $applicationId = DB::table('topic_applications')->insertGetId([
            'lecturer_topic_id' => $topicId,
            'student_id' => $studentId,
            'document_path' => 'topic_applications/proposal.pdf',
            'requirements_note' => 'Proposal tersedia.',
            'message' => 'Mohon disetujui.',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('topic-applications.approve', $applicationId));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Aplikasi disetujui.');

        $this->assertDatabaseHas('topic_applications', [
            'id' => $applicationId,
            'status' => 'approved',
        ]);
    }

    public function test_reject_application_changes_status_to_rejected()
    {
        $lecturerId = $this->createLecturer();
        $topicId = $this->createLecturerTopic($lecturerId);
        $studentId = DB::table('students')->insertGetId([
            'student_id' => 'NIM12345',
            'name' => 'Dewi Rahma',
            'email' => 'dewi.rahma@uad.ac.id',
            'year_entrance' => 2023,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $applicationId = DB::table('topic_applications')->insertGetId([
            'lecturer_topic_id' => $topicId,
            'student_id' => $studentId,
            'document_path' => 'topic_applications/proposal.pdf',
            'requirements_note' => 'Proposal tersedia.',
            'message' => 'Mohon ditolak untuk demo.',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $response = $this->post(route('topic-applications.reject', $applicationId));
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Aplikasi ditolak. Topik kembali dibuka.');
        $this->assertDatabaseHas('topic_applications', [
            'id' => $applicationId,
            'status' => 'rejected',
        ]);
    }
}
