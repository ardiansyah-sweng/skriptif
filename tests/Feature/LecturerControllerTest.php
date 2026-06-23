<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LecturerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_lecturers_list()
    {
        // Insert mock lecturers with different created_at to verify desc ordering
        $now = now();
        DB::table('lecturers')->insert([
            [
                'lecturer_id' => 'L001',
                'name' => 'Lecturer One',
                'email' => 'one@example.com',
                'expertise' => 'AI',
                'created_at' => $now->copy()->subMinutes(10),
                'updated_at' => $now->copy()->subMinutes(10),
            ],
            [
                'lecturer_id' => 'L002',
                'name' => 'Lecturer Two',
                'email' => 'two@example.com',
                'expertise' => 'Robotics',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        $response = $this->get(route('lecturers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lecturers.index');
        $response->assertViewHas('lecturers');

        $lecturers = $response->viewData('lecturers');
        $this->assertCount(2, $lecturers);
        // Verify sorting by created_at desc (L002 should be first, then L001)
        $this->assertEquals('L002', $lecturers->first()->lecturer_id);
        $this->assertEquals('L001', $lecturers->last()->lecturer_id);
    }

    public function test_store_saves_valid_lecturer_and_redirects()
    {
        $data = [
            'lecturer_id' => 'L003',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'expertise' => 'Web Development',
        ];

        $response = $this->post(route('lecturers.store'), $data);

        $response->assertRedirect(route('lecturers.index'));
        $response->assertSessionHas('success', 'Data dosen berhasil ditambahkan.');

        $this->assertDatabaseHas('lecturers', [
            'lecturer_id' => 'L003',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'expertise' => 'Web Development',
        ]);
    }

    public function test_store_validation_fails_on_missing_required_fields()
    {
        $response = $this->post(route('lecturers.store'), [
            'lecturer_id' => '',
            'name' => '',
            'email' => '',
        ]);

        $response->assertSessionHasErrors(['lecturer_id', 'name', 'email']);
        $this->assertDatabaseCount('lecturers', 0);
    }

    public function test_store_validation_fails_on_duplicate_lecturer_id_or_email()
    {
        // Pre-insert a lecturer
        DB::table('lecturers')->insert([
            'lecturer_id' => 'L001',
            'name' => 'Existing Lecturer',
            'email' => 'existing@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Try to insert same lecturer_id but different email
        $response1 = $this->post(route('lecturers.store'), [
            'lecturer_id' => 'L001',
            'name' => 'Another Lecturer',
            'email' => 'another@example.com',
        ]);
        $response1->assertSessionHasErrors(['lecturer_id']);

        // Try to insert different lecturer_id but same email
        $response2 = $this->post(route('lecturers.store'), [
            'lecturer_id' => 'L002',
            'name' => 'Another Lecturer',
            'email' => 'existing@example.com',
        ]);
        $response2->assertSessionHasErrors(['email']);

        $this->assertDatabaseCount('lecturers', 1);
    }

    public function test_destroy_deletes_existing_lecturer()
    {
        $id = DB::table('lecturers')->insertGetId([
            'lecturer_id' => 'L001',
            'name' => 'Lecturer to Delete',
            'email' => 'delete@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('lecturers', ['id' => $id]);

        $response = $this->delete(route('lecturers.destroy', $id));

        $response->assertRedirect(route('lecturers.index'));
        $response->assertSessionHas('success', 'Data dosen berhasil dihapus.');

        $this->assertDatabaseMissing('lecturers', ['id' => $id]);
    }

    public function test_destroy_returns_404_for_non_existing_lecturer()
    {
        $response = $this->delete(route('lecturers.destroy', 9999));

        $response->assertStatus(404);
    }
}
