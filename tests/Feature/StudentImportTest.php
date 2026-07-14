<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentImportTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function test_import_berhasil()
    {
        $tempPath = storage_path('app/temp_test_mahasiswa.csv');
        
        $fileHandle = fopen($tempPath, 'w');
        
        fputcsv($fileHandle, ['student_id', 'name', 'email', 'year_entrance', 'status']);
        
        fputcsv($fileHandle, ['2300018175', 'Diran Rama Yuda', '2300018175@webmail.uad.ac.id', '2023', 'Aktif']);
        
        fputcsv($fileHandle, ['2300018176', 'Udin Sedunia', 'udin.sedunia@example.com', '2023', 'Cuti']);
        
        fclose($fileHandle);

        $file = new UploadedFile(
            $tempPath, 
            'mahasiswa_test.csv', 
            'text/csv', 
            null, 
            true
        );

        $response = $this->post(route('students.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'student_id' => '2300018175',
            'name'       => 'Diran Rama Yuda',
        ]);

        //if (file_exists($tempPath)) {
        //    unlink($tempPath);
        //}
    }
}