<?php

namespace App\Providers;

use App\Models\Skripsi;
use App\Notifications\SkripsiStatusUpdated;
use App\Notifications\NewSkripsiSubmitted;
use Illuminate\Support\Facades\Log;

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
        $skripsi = Skripsi::create([
            'student_id'      => $data['student_id'],
            'supervisor_id'   => $data['supervisor_id'],
            'title'           => $data['title'],
            'description'     => $data['description'],
            'status'          => 'pending',
            'submission_date' => now()->toDateString(),
        ]);

        // Kirim notifikasi ke dosen pembimbing yang dipilih
        $skripsi->load(['student', 'supervisor']);
        if ($account = $skripsi->supervisor->account()) {
            $account->notify(new NewSkripsiSubmitted($skripsi));
        } else {
            Log::warning('Notifikasi pengajuan skripsi baru gagal dikirim: tidak ada User dengan email ' . $skripsi->supervisor->email);
        }

        return $skripsi;
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

        // Kirim notifikasi ke mahasiswa saat pengajuan disetujui/ditolak
        if (in_array($skripsi->status, ['approved', 'rejected'])) {
            $skripsi->load('student');
            if ($account = $skripsi->student->account()) {
                $account->notify(new SkripsiStatusUpdated($skripsi));
            } else {
                Log::warning('Notifikasi status skripsi gagal dikirim: tidak ada User dengan email ' . $skripsi->student->email);
            }
        }

        return $skripsi;
    }
}