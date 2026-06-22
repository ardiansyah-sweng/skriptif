<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StudentImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_import_berhasil()
    {
        $file = UploadedFile::fake()->create('mahasiswa.xlsx', 500, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $response = $this->post(route('students.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');
    }
}