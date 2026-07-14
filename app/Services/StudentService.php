<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService
{
    protected $repo;

    public function __construct(StudentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function importCsv($file)
    {
        if (($handle = fopen($file->getPathname(), 'r')) !== FALSE) {
            
            fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (empty($row[0])) continue;

                $this->repo->upsertData([
                    'student_id'    => $row[0],
                    'name'          => $row[1],
                    'email'         => $row[2],
                    'year_entrance' => $row[3],
                    'status'        => $row[4],
                ]);
            }
            fclose($handle);
        }
    }
}