<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Bimbingan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbinganModelTest extends TestCase
{
    public function test_it_has_correct_table_name()
    {
        $bimbingan = new Bimbingan();

        $this->assertEquals('bimbingans', $bimbingan->getTable());
    }

    public function test_it_has_fillable_attributes()
    {
        $bimbingan = new Bimbingan();

        $this->assertEquals([
            'skripsi_id',
            'lecturer_id',
            'tanggal_bimbingan',
            'catatan',
        ], $bimbingan->getFillable());
    }

    public function test_it_has_correct_casts()
    {
        $bimbingan = new Bimbingan();

        $casts = $bimbingan->getCasts();

        $this->assertArrayHasKey('tanggal_bimbingan', $casts);
        $this->assertEquals('date', $casts['tanggal_bimbingan']);
    }

    public function test_it_belongs_to_skripsi()
    {
        $bimbingan = new Bimbingan();

        $this->assertInstanceOf(BelongsTo::class, $bimbingan->skripsi());
    }

    public function test_it_belongs_to_lecturer()
    {
        $bimbingan = new Bimbingan();

        $this->assertInstanceOf(BelongsTo::class, $bimbingan->lecturer());
    }
}
