<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentSkripsiControllerTest extends TestCase
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

    private function createElectiveCourse(array $override = []): int
    {
        return DB::table('elective_courses')->insertGetId(array_merge([
            'courses'   => 'Pemrograman Web',
            'timestamp' => now(),
        ], $override));
    }

    public function test_halaman_create_menampilkan_view_dengan_data_dosen_dan_matkul_pilihan()
    {
        $lecturerId = $this->createLecturer();
        $courseId   = $this->createElectiveCourse();

        $response = $this->get('/mahasiswa/skripsi/create');

        $response->assertViewIs('mahasiswa.skripsi.create');
        $response->assertViewHas('lecturers');
        $response->assertViewHas('electiveCourses');
    }

    public function test_store_skripsi_berhasil()
    {
        $studentId   = $this->createStudent();
        $lecturerId  = $this->createLecturer();
        $courseId    = $this->createElectiveCourse();

        $response = $this->post('/mahasiswa/skripsi', [
            'title'             => 'Sistem Informasi Skripsi',
            'description'       => 'Membangun sistem informasi untuk manajemen skripsi.',
            'supervisor_id'     => $lecturerId,
            'elective_courses'  => [
                ['id' => $courseId, 'grade' => 'A'],
            ],
        ]);

        $response->assertRedirect(route('student.skripsi.history'));
        $response->assertSessionHas('success', 'Pengajuan berhasil!');

        $this->assertDatabaseHas('skripsi', [
            'student_id'            => $studentId,
            'supervisor_id'         => $lecturerId,
            'title'                 => 'Sistem Informasi Skripsi',
            'description'           => 'Membangun sistem informasi untuk manajemen skripsi.',
            'status'                => 'pending',
        ]);
    }

    public function test_store_skripsi_gagal_saat_tidak_ada_data_mahasiswa()
    {
        $lecturerId = $this->createLecturer();
        $courseId   = $this->createElectiveCourse();

        $response = $this->from('/mahasiswa/skripsi/create')->post('/mahasiswa/skripsi', [
            'title'             => 'Sistem Informasi Skripsi',
            'description'       => 'Membangun sistem informasi untuk manajemen skripsi.',
            'supervisor_id'     => $lecturerId,
            'elective_courses'  => [
                ['id' => $courseId, 'grade' => 'A'],
            ],
        ]);

        $response->assertRedirect('/mahasiswa/skripsi/create');
        $response->assertSessionHas('error', 'Tidak ada data mahasiswa.');
    }

    public function test_store_skripsi_gagal_saat_validasi_gagal()
    {
        $response = $this->post('/mahasiswa/skripsi', []);

        $response->assertSessionHasErrors(['title', 'description', 'supervisor_id', 'elective_courses']);
    }

    public function test_store_skripsi_berhasil_meskipun_tanpa_nilai_matkul_pilihan()
    {
        $studentId   = $this->createStudent();
        $lecturerId  = $this->createLecturer();
        $courseId    = $this->createElectiveCourse();

        $response = $this->post('/mahasiswa/skripsi', [
            'title'             => 'Sistem Informasi Skripsi',
            'description'       => 'Membangun sistem informasi untuk manajemen skripsi.',
            'supervisor_id'     => $lecturerId,
            'elective_courses'  => [
                ['id' => $courseId],
            ],
        ]);

        $response->assertRedirect(route('student.skripsi.history'));

        $this->assertDatabaseHas('skripsi', [
            'student_id'    => $studentId,
            'title'         => 'Sistem Informasi Skripsi',
        ]);
    }

    public function test_halaman_history_menampilkan_view_dengan_data_skripsi()
    {
        $studentId  = $this->createStudent();
        $lecturerId = $this->createLecturer();

        DB::table('skripsi')->insert([
            'student_id'      => $studentId,
            'supervisor_id'   => $lecturerId,
            'title'           => 'Skripsi 1',
            'description'     => 'Deskripsi skripsi 1',
            'status'          => 'pending',
            'submission_date' => now(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $response = $this->get('/mahasiswa/skripsi/history');

        $response->assertViewIs('mahasiswa.skripsi.history');
        $response->assertViewHas('skripsis');
    }

    public function test_halaman_history_mengembalikan_koleksi_kosong_saat_tidak_ada_mahasiswa()
    {
        $response = $this->get('/mahasiswa/skripsi/history');

        $response->assertViewIs('mahasiswa.skripsi.history');
        $response->assertViewHas('skripsis');

        $skripsis = $response->viewData('skripsis');
        $this->assertCount(0, $skripsis);
    }
}