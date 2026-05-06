<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelStudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_can_create_student()
    {
        $student = Student::create([
            'student_id' => 'S001',
            'name' => 'Girhan',
            'email' => 'girhan@test.com',
            'year_entrance' => 2023,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('students', [
            'student_id' => 'S001',
            'email' => 'girhan@test.com',
        ]);
    }

    /** @test */
    public function test_it_can_get_all_students()
    {
        Student::create([
            'student_id' => 'S002',
            'name' => 'Test',
            'email' => 'test@test.com',
            'year_entrance' => 2022,
            'status' => 'active',
        ]);

        $students = Student::all();

        $this->assertCount(1, $students);
    }

    /** @test */
    public function test_it_stores_correct_data()
    {
        $student = Student::create([
            'student_id' => 'S003',
            'name' => 'Valid',
            'email' => 'valid@test.com',
            'year_entrance' => 2021,
            'status' => 'inactive',
        ]);

        $this->assertEquals('Valid', $student->name);
        $this->assertEquals('inactive', $student->status);
    }
}