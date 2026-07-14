<?php

namespace App\Providers;

use App\Models\Skripsi;

class SkripsiService
{
    public function getAllSkripsi($search = null, $status = null)
{
    $query = Skripsi::with(['student', 'supervisor']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('student', function ($student) use ($search) {
                  $student->where('name', 'like', "%{$search}%")
                          ->orWhere('student_id', 'like', "%{$search}%");
              });
        });
    }

    if ($status) {
        $query->where('status', $status);
    }

    return $query->latest()->get();
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