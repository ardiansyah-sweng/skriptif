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

    public function test_index_displays_lecturers()
    {
        $this->createLecturer();
        $this->createLecturer([
            'lecturer_id' => 'LCT002',
            'name'        => 'Prof. Budi Santoso',
            'email'       => 'budi@uad.ac.id',
        ]);

        $response = $this->get(route('lecturers.index'));

        $response->assertStatus(200);
        $response->assertSee('Dr. Ahmad Fauzi');
        $response->assertSee('Prof. Budi Santoso');
        $response->assertSee('LCT001');
        $response->assertSee('LCT002');
    }

    public function test_index_shows_empty_state()
    {
        $response = $this->get(route('lecturers.index'));

        $response->assertStatus(200);
        $response->assertSee('Tidak ada data dosen');
    }

    public function test_edit_displays_lecturer_data()
    {
        $id = $this->createLecturer();

        $response = $this->get(route('lecturers.edit', $id));

        $response->assertStatus(200);
        $response->assertSee('Dr. Ahmad Fauzi');
        $response->assertSee('ahmad.fauzi@uad.ac.id');
        $response->assertSee('LCT001');
        $response->assertSee('Rekayasa Perangkat Lunak');
    }

    public function test_update_lecturer_success()
    {
        $id = $this->createLecturer();

        $response = $this->put(route('lecturers.update', $id), [
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi Updated',
            'email'       => 'ahmad.updated@uad.ac.id',
            'expertise'   => 'Data Science',
        ]);

        $response->assertRedirect(route('lecturers.index'));
        $this->assertDatabaseHas('lecturers', [
            'id'    => $id,
            'name'  => 'Dr. Ahmad Fauzi Updated',
            'email' => 'ahmad.updated@uad.ac.id',
            'expertise' => 'Data Science',
        ]);
    }

    public function test_update_validates_required_fields()
    {
        $id = $this->createLecturer();

        $response = $this->put(route('lecturers.update', $id), [
            'lecturer_id' => '',
            'name'        => '',
            'email'       => '',
        ]);

        $response->assertSessionHasErrors(['lecturer_id', 'name', 'email']);
    }

    public function test_update_validates_unique_email()
    {
        $this->createLecturer();
        $id2 = $this->createLecturer([
            'lecturer_id' => 'LCT002',
            'name'        => 'Prof. Budi',
            'email'       => 'budi@uad.ac.id',
        ]);

        $response = $this->put(route('lecturers.update', $id2), [
            'lecturer_id' => 'LCT002',
            'name'        => 'Prof. Budi',
            'email'       => 'ahmad.fauzi@uad.ac.id',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_update_allows_same_email_for_same_lecturer()
    {
        $id = $this->createLecturer();

        $response = $this->put(route('lecturers.update', $id), [
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi Edited',
            'email'       => 'ahmad.fauzi@uad.ac.id',
            'expertise'   => 'Rekayasa Perangkat Lunak',
        ]);

        $response->assertRedirect(route('lecturers.index'));
        $response->assertSessionHasNoErrors();
    }

    public function test_store_lecturer_success()
    {
        $response = $this->post(route('lecturers.store'), [
            'lecturer_id' => 'LCT001',
            'name'        => 'Dr. Ahmad Fauzi',
            'email'       => 'ahmad.fauzi@uad.ac.id',
            'expertise'   => 'Rekayasa Perangkat Lunak',
        ]);

        $response->assertRedirect(route('lecturers.index'));
        $this->assertDatabaseHas('lecturers', [
            'lecturer_id' => 'LCT001',
            'email'       => 'ahmad.fauzi@uad.ac.id',
        ]);
    }

    public function test_delete_lecturer_success()
    {
        $id = $this->createLecturer();

        $response = $this->delete(route('lecturers.destroy', $id));

        $response->assertRedirect(route('lecturers.index'));
        $this->assertDatabaseMissing('lecturers', [
            'id' => $id,
        ]);
    }
}
