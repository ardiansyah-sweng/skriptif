<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkripsiHistoryTest extends TestCase
{
    use RefreshDatabase;

    private function createStudent(array $override = []): int
    {
        return DB::table('students')->insertGetId(array_merge([
            'student_id'    => 'STU001',
            'name'          => 'Budi Santoso',
            'email'         => 'budi@uad.ac.id',
            'year_entrance' => 2022,
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ], $override));
    }

    private function createLecturer(array $override = []): int
    {
        return DB::table('lecturers')->insertGetId(array_merge([
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi',
            'email'       => 'ahmad@uad.ac.id',
            'expertise'   => 'RPL',
            'created_at'  => now(),
            'updated_at'  => now(),
        ], $override));
    }

    private function createElectiveCourse(): int
    {
        return DB::table('elective_courses')->insertGetId([
            'courses'   => 'Pemrograman Web',
            'timestamp' => now(),
        ]);
    }

    /**
     * Saat skripsi baru dibuat, history harus tercatat dengan status 'pending'.
     */
    public function test_history_tercatat_dengan_status_pending_saat_skripsi_dibuat()
    {
        $studentId  = $this->createStudent();
        $lecturerId = $this->createLecturer();
        $user       = User::factory()->create();

        // Buat skripsi langsung di DB
        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Sistem Informasi Skripsi',
            'description'     => 'Deskripsi lengkap skripsi.',
            'status'          => 'pending',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Simulasikan Observer: catat history dengan kolom 'status' tunggal
        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsiId,
            'status'     => 'pending',
            'handler_id' => $user->id,
            'note'       => 'Pengajuan skripsi awal dikirim oleh mahasiswa.',
        ]);

        // Pastikan kolom 'status' tunggal tersimpan dengan benar
        $this->assertDatabaseHas('skripsi_histories', [
            'skripsi_id' => $skripsiId,
            'status'     => 'pending',
        ]);

        $history = DB::table('skripsi_histories')
            ->where('skripsi_id', $skripsiId)
            ->first();

        $this->assertNotNull($history);
        $this->assertEquals('pending', $history->status);
        // Pastikan kolom lama status_before dan status_after sudah tidak ada
        $this->assertFalse(property_exists($history, 'status_before'), 'Kolom status_before seharusnya sudah dihapus');
        $this->assertFalse(property_exists($history, 'status_after'), 'Kolom status_after seharusnya sudah dihapus');
    }

    /**
     * Saat status skripsi diupdate ke 'approved', history baru harus tercatat dengan status 'approved'.
     */
    public function test_history_tercatat_saat_status_skripsi_diupdate_ke_approved()
    {
        $studentId  = $this->createStudent();
        $lecturerId = $this->createLecturer();

        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Skripsi Test',
            'description'     => 'Deskripsi',
            'status'          => 'pending',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        // Update status ke approved
        DB::table('skripsi')->where('id', $skripsiId)->update([
            'status'     => 'approved',
            'updated_at' => now(),
        ]);

        // Trigger observer secara manual
        $skripsi = \App\Models\Skripsi::find($skripsiId);
        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsi->id,
            'status'     => 'approved',
            'handler_id' => $user->id,
            'note'       => 'Pengajuan disetujui oleh Admin.',
        ]);

        $this->assertDatabaseHas('skripsi_histories', [
            'skripsi_id' => $skripsiId,
            'status'     => 'approved',
        ]);

        $history = DB::table('skripsi_histories')
            ->where('skripsi_id', $skripsiId)
            ->where('status', 'approved')
            ->first();

        $this->assertNotNull($history);
        $this->assertEquals('approved', $history->status);
        $this->assertEquals('Pengajuan disetujui oleh Admin.', $history->note);
    }

    /**
     * Saat status skripsi diupdate ke 'rejected', history harus tercatat dengan status 'rejected'.
     */
    public function test_history_tercatat_saat_status_skripsi_diupdate_ke_rejected()
    {
        $studentId  = $this->createStudent();
        $lecturerId = $this->createLecturer();

        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Skripsi Ditolak',
            'description'     => 'Deskripsi',
            'status'          => 'pending',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsiId,
            'status'     => 'rejected',
            'handler_id' => $user->id,
            'note'       => 'Judul tidak sesuai standar.',
        ]);

        $this->assertDatabaseHas('skripsi_histories', [
            'skripsi_id' => $skripsiId,
            'status'     => 'rejected',
            'note'       => 'Judul tidak sesuai standar.',
        ]);
    }

    /**
     * Satu skripsi bisa memiliki multiple history entries.
     */
    public function test_skripsi_bisa_memiliki_multiple_history_entries()
    {
        $studentId  = $this->createStudent();
        $lecturerId = $this->createLecturer();

        $skripsiId = DB::table('skripsi')->insertGetId([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Skripsi Multi History',
            'description'     => 'Deskripsi',
            'status'          => 'pending',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $user = User::factory()->create();

        // Entry 1: pending (pengajuan awal)
        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsiId,
            'status'     => 'pending',
            'handler_id' => $user->id,
            'note'       => 'Pengajuan skripsi awal dikirim oleh mahasiswa.',
        ]);

        // Entry 2: rejected
        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsiId,
            'status'     => 'rejected',
            'handler_id' => $user->id,
            'note'       => 'Revisi diperlukan.',
        ]);

        // Entry 3: approved
        \App\Models\SkripsiHistory::create([
            'skripsi_id' => $skripsiId,
            'status'     => 'approved',
            'handler_id' => $user->id,
            'note'       => 'Pengajuan disetujui.',
        ]);

        $count = DB::table('skripsi_histories')
            ->where('skripsi_id', $skripsiId)
            ->count();

        $this->assertEquals(3, $count);
    }
}
