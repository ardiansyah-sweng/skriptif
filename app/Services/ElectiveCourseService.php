<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ElectiveCourseService
{
    public function importCsv($file)
    {
        if (($handle = fopen($file->getPathname(), 'r')) !== FALSE) {
            // Skip header row
            fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (empty($row[0])) continue;

                DB::table('elective_courses')->insert([
                    'courses'   => trim($row[0]),
                    'timestamp' => now(),
                ]);
            }
            fclose($handle);
        }
    }
}