<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;

class ModelStudentTest extends TestCase
{
    public function test_it_has_correct_table_name()
    {
        $student = new Student();

        $this->assertEquals('students', $student->getTable());
    }

    public function test_it_has_fillable_attributes()
    {
        $student = new Student();

        $this->assertEquals([
            'student_id',
            'name',
            'email',
            'year_entrance',
            'status',
            'is_lulus',
        ], $student->getFillable());
    }

    public function test_it_has_correct_casts()
    {
        $student = new Student();

        $casts = $student->getCasts();

        $this->assertArrayHasKey('year_entrance', $casts);
        $this->assertEquals('integer', $casts['year_entrance']);
    }

    public function test_it_uses_timestamps()
    {
        $student = new Student();

        $this->assertTrue($student->timestamps);
    }
}