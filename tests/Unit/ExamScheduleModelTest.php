<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ExamSchedule;

class ExamScheduleModelTest extends TestCase
{
    public function test_it_has_correct_table_name()
    {
        $schedule = new ExamSchedule();

        $this->assertEquals('exam_schedules', $schedule->getTable());
    }

    public function test_it_has_fillable_attributes()
    {
        $schedule = new ExamSchedule();

        $this->assertEquals([
            'skripsi_id',
            'jenis_sidang',
            'tanggal_sidang',
            'jam_mulai',
            'jam_selesai',
            'ruang',
            'status',
            'catatan',
        ], $schedule->getFillable());
    }

    public function test_it_has_correct_casts()
    {
        $schedule = new ExamSchedule();

        $casts = $schedule->getCasts();

        $this->assertArrayHasKey('tanggal_sidang', $casts);
        $this->assertEquals('date', $casts['tanggal_sidang']);
    }

    public function test_it_belongs_to_skripsi()
    {
        $schedule = new ExamSchedule();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $schedule->skripsi()
        );
    }

    public function test_it_has_default_status()
    {
        $schedule = new ExamSchedule();

        $attributes = $schedule->getAttributes();

        $this->assertArrayHasKey('status', $attributes);
        $this->assertEquals('terjadwal', $attributes['status']);
    }
}
