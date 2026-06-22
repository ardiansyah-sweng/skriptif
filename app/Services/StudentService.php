<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentService
{
    protected $repo;

    public function __construct(StudentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function importExcel($file)
    {
        $spreadsheet = IOFactory::load($file->getPathname());
        $rows = $spreadsheet->getActiveSheet()->toArray();
        array_shift($rows);

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            // Service kirim data bersih ke Repository
            $this->repo->upsertData([
                'student_id'    => $row[0],
                'name'          => $row[1],
                'email'         => $row[2],
                'year_entrance' => $row[3],
                'status'        => $row[4],
            ]);
        }
    }
}