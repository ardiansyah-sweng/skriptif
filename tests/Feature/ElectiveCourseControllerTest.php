<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ElectiveCourseControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createElectiveCourse(array $override = []): int
    {
        return DB::table('elective_courses')->insertGetId(array_merge([
            'courses'   => 'Pemrograman Mobile',
            'timestamp' => now(),
        ], $override));
    }

    public function test_index_displays_elective_courses()
    {
        $this->createElectiveCourse();
        $this->createElectiveCourse([
            'courses' => 'Keamanan Jaringan Komputer',
        ]);

        $response = $this->get(route('elective-courses.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Pemrograman Mobile');
        $response->assertSeeText('Keamanan Jaringan Komputer');
        $response->assertSeeText('mata kuliah tersedia');
    }

    public function test_search_filters_elective_courses_by_name()
    {
        $this->createElectiveCourse();
        $this->createElectiveCourse([
            'courses' => 'Keamanan Jaringan Komputer',
        ]);

        $response = $this->get(route('elective-courses.search', ['q' => 'Mobile']));

        $response->assertStatus(200);
        $response->assertSeeText('Pemrograman Mobile');
        $response->assertDontSeeText('Keamanan Jaringan Komputer');
    }

    public function test_show_displays_elective_course_details()
    {
        $id = $this->createElectiveCourse([
            'courses' => 'Sistem Terdistribusi',
        ]);

        $response = $this->get(route('elective-courses.show', $id));

        $response->assertStatus(200);
        $response->assertSeeText('Detail Mata Kuliah Pilihan');
        $response->assertSeeText('Sistem Terdistribusi');
        $response->assertSeeText('ID Course');
    }
}
