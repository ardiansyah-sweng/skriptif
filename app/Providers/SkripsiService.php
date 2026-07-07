<?php

namespace App\Providers;

use App\Models\Skripsi;

class SkripsiService
{
    public function getAllSkripsi()
    {
        return Skripsi::with(['student', 'supervisor'])->get();
    }

    public function submitSkripsi(array $data)
    {
        return Skripsi::create([
            'student_id'      => $data['student_id'],
            'supervisor_id'   => $data['supervisor_id'],
            'title'           => $data['title'],
            'description'     => $data['description'],
            'status'          => 'pending',
            'submission_date' => now()->toDateString(),
        ]);
    }

    public function updateStatus($id, array $data)
    {
        $skripsi = Skripsi::findOrFail($id);

        $updateData = [
            'status'         => $data['status'],
            'rejection_note' => $data['rejection_note'] ?? null,
        ];

        if ($data['status'] === 'approved') {
            $updateData['approval_date'] = now()->toDateString();
        }

        $skripsi->update($updateData);
        return $skripsi;
    }
    public function getLecturerQuotaStats()
    {
        // Ambil semua data dosen
        $lecturers = \App\Models\Lecturer::all();

        return $lecturers->map(function ($lecturer) {
            $current = $lecturer->active_bimbingan_count;
            $max = $lecturer->max_quota ?? 5;
            
            $persentase = $max > 0 ? ($current / $max) * 100 : 0;

            // Logika penentuan warna progress bar Bootstrap
            $color = 'bg-success'; 
            if ($persentase >= 100) {
                $color = 'bg-danger'; 
            } elseif ($persentase >= 60) {
                $color = 'bg-warning'; 
            }

            return [
                'name' => $lecturer->name,
                'current' => $current,
                'max' => $max,
                'persentase' => $persentase,
                'color' => $color
            ];
        });
    }
}