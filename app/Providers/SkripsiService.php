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
}