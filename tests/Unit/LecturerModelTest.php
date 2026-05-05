<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Lecturer;

class LecturerModelTest extends TestCase
{
    public function test_lecturer_model_maps_to_table(): void
    {
        $lecturer = new Lecturer();
        $this->assertSame('lecturers', $lecturer->getTable());
    }

    public function test_lecturer_model_has_fillable(): void
    {
        $lecturer = new Lecturer();
        $expected = [
            'lecturer_id',
            'name',
            'email',
            'expertise'
        ];

        $this->assertSame($expected, $lecturer->getFillable());
    }

    public function test_lecturer_model_timestamps_enabled(): void
    {
        $lecturer = new Lecturer();
        $this->assertTrue($lecturer->timestamps);
    }
}