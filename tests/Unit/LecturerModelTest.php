<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Lecturer;

class LecturerModelTest extends TestCase
{
    public function test_it_has_correct_table_name()
    {
        $lecturer = new Lecturer();

        $this->assertEquals('lecturers', $lecturer->getTable());
    }

    public function test_it_has_fillable_attributes()
    {
        $lecturer = new Lecturer();

        $this->assertEquals([
            'lecturer_id',
            'name',
            'email',
            'expertise',
            'max_supervisors',
            'status',
        ], $lecturer->getFillable());
    }

    public function test_it_has_default_attributes()
    {
        $lecturer = new Lecturer();

        $attributes = $lecturer->getAttributes();

        $this->assertArrayHasKey('status', $attributes);
        $this->assertEquals('active', $attributes['status']);
    }

    public function test_it_uses_timestamps()
    {
        $lecturer = new Lecturer();

        $this->assertTrue($lecturer->timestamps);
    }
}