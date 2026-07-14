<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository 
{
    /**
     * Menyimpan atau mengupdate data mahasiswa ke database.
     */
    public function upsertData(array $data)
    {
        return Student::updateOrCreate(
            ['student_id' => $data['student_id']], // Syarat unik: NIM
            [
                'name'          => $data['name'],
                'email'         => $data['email'],
                'year_entrance' => $data['year_entrance'],
                'status'        => $data['status'],
            ]
        );
    }
}