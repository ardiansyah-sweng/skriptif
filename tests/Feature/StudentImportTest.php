<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentImportTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function test_import_berhasil()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'student_id');
        $sheet->setCellValue('B1', 'name');
        $sheet->setCellValue('C1', 'email');
        $sheet->setCellValue('D1', 'year_entrance');
        $sheet->setCellValue('E1', 'status');

        $sheet->setCellValue('A2', '2300018175');
        $sheet->setCellValue('B2', 'Diran Rama Yuda');
        $sheet->setCellValue('C2', '2300018175@webmail.uad.ac.id');
        $sheet->setCellValue('D2', '2023');
        $sheet->setCellValue('E2', 'Aktif');

        $sheet->setCellValue('A3', '2300018176');
        $sheet->setCellValue('B3', 'Udin Sedunia');
        $sheet->setCellValue('C3', 'udin.sedunia@example.com');
        $sheet->setCellValue('D3', '2023');
        $sheet->setCellValue('E3', 'Cuti');

        $writer = new Xlsx($spreadsheet);
        $tempPath = storage_path('app/temp_test_mahasiswa.xlsx');
        $writer->save($tempPath);

        $file = new UploadedFile(
            $tempPath, 
            'mahasiswa_test.xlsx', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
            null, 
            true
        );

        $response = $this->post(route('students.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        unlink($tempPath);
    }
}