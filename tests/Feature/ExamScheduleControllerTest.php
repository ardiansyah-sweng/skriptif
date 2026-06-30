<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExamScheduleControllerTest extends TestCase
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
            'email'       => 'ahmad.fauzi@uad.ac.id',
            'expertise'   => 'Rekayasa Perangkat Lunak',
            'created_at'  => now(),
            'updated_at'  => now(),
        ], $override));
    }

    private function createApprovedSkripsi(int $studentId, int $lecturerId): int
    {
        return DB::table('skripsi')->insertGetId([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Rancang Bangun Web Skripsi',
            'description'     => 'Deskripsi lengkap...',
            'status'          => 'approved',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    public function test_store_jadwal_sidang_berhasil_jika_jenis_sidang_belum_ada()
    {
        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();
        $skripsiId = $this->createApprovedSkripsi($studentId, $lecturerId);

        $response = $this->post('/exam-schedules', [
            'skripsi_id'     => $skripsiId,
            'jenis_sidang'   => 'proposal',
            'tanggal_sidang' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai'      => '09:00',
            'jam_selesai'    => '10:00',
            'ruang'          => 'Ruang 301',
            'catatan'        => 'Harap datang 15 menit sebelum mulai.',
        ]);

        $response->assertRedirect(route('exam-schedules.index'));
        $response->assertSessionHas('success', 'Jadwal sidang berhasil ditambahkan.');

        $this->assertDatabaseHas('exam_schedules', [
            'skripsi_id'   => $skripsiId,
            'jenis_sidang' => 'proposal',
            'ruang'        => 'Ruang 301',
        ]);
    }

    public function test_store_jadwal_sidang_gagal_jika_jenis_sidang_yang_sama_sudah_ada()
    {
        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();
        $skripsiId = $this->createApprovedSkripsi($studentId, $lecturerId);

        // Tambahkan jadwal sidang proposal pertama
        DB::table('exam_schedules')->insert([
            'skripsi_id'     => $skripsiId,
            'jenis_sidang'   => 'proposal',
            'tanggal_sidang' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai'      => '09:00:00',
            'jam_selesai'    => '10:00:00',
            'ruang'          => 'Ruang 301',
            'status'         => 'terjadwal',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Coba tambahkan jadwal sidang proposal kedua untuk mahasiswa / skripsi yang sama
        $response = $this->from('/exam-schedules/create')->post('/exam-schedules', [
            'skripsi_id'     => $skripsiId,
            'jenis_sidang'   => 'proposal',
            'tanggal_sidang' => now()->addDays(14)->format('Y-m-d'),
            'jam_mulai'      => '11:00',
            'jam_selesai'    => '12:00',
            'ruang'          => 'Ruang 302',
            'catatan'        => 'Uji coba duplikat.',
        ]);

        $response->assertRedirect('/exam-schedules/create');
        $response->assertSessionHasErrors(['jenis_sidang']);

        // Pastikan record di database tidak bertambah untuk jenis sidang proposal
        $this->assertEquals(
            1,
            DB::table('exam_schedules')
                ->where('skripsi_id', $skripsiId)
                ->where('jenis_sidang', 'proposal')
                ->count()
        );
    }

    public function test_store_jadwal_sidang_berhasil_jika_jenis_sidang_berbeda()
    {
        $studentId = $this->createStudent();
        $lecturerId = $this->createLecturer();
        $skripsiId = $this->createApprovedSkripsi($studentId, $lecturerId);

        // Tambahkan jadwal sidang proposal pertama
        DB::table('exam_schedules')->insert([
            'skripsi_id'     => $skripsiId,
            'jenis_sidang'   => 'proposal',
            'tanggal_sidang' => now()->addDays(7)->format('Y-m-d'),
            'jam_mulai'      => '09:00:00',
            'jam_selesai'    => '10:00:00',
            'ruang'          => 'Ruang 301',
            'status'         => 'terjadwal',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Tambahkan jadwal sidang hasil (jenis sidang berbeda)
        $response = $this->post('/exam-schedules', [
            'skripsi_id'     => $skripsiId,
            'jenis_sidang'   => 'hasil',
            'tanggal_sidang' => now()->addDays(14)->format('Y-m-d'),
            'jam_mulai'      => '13:00',
            'jam_selesai'    => '14:00',
            'ruang'          => 'Ruang 302',
            'catatan'        => 'Jadwal sidang hasil.',
        ]);

        $response->assertRedirect(route('exam-schedules.index'));
        $response->assertSessionHas('success', 'Jadwal sidang berhasil ditambahkan.');

        $this->assertDatabaseHas('exam_schedules', [
            'skripsi_id'   => $skripsiId,
            'jenis_sidang' => 'hasil',
        ]);
    }
}
