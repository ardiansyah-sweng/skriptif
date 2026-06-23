<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_loads_successfully_and_shows_correct_statistics()
    {
        // Insert mock lecturer
        DB::table('lecturers')->insert([
            'lecturer_id' => '123456',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'expertise' => 'Software Engineering',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert mock students (1 active, 1 inactive)
        DB::table('students')->insert([
            [
                'student_id' => 'S123',
                'name' => 'Alice',
                'email' => 'alice@example.com',
                'year_entrance' => 2023,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'S124',
                'name' => 'Bob',
                'email' => 'bob@example.com',
                'year_entrance' => 2022,
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert mock elective course
        DB::table('elective_courses')->insert([
            'courses' => 'Advanced Database',
            'timestamp' => now(),
        ]);

        // Access dashboard
        $response = $this->get('/dashboard');

        // Assert response status
        $response->assertStatus(200);

        // Assert data passed to view is correct
        $response->assertViewHas('totalLecturers', 1);
        $response->assertViewHas('activeLecturers', 1); // since all are active by default
        $response->assertViewHas('totalStudents', 2);
        $response->assertViewHas('activeStudents', 1);
        $response->assertViewHas('totalCourses', 1);
    }
}
