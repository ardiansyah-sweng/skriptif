<?php

namespace App\Observers;

use App\Models\Skripsi;
use App\Models\SkripsiHistory;

class SkripsiObserver
{
    /**
     * Handle the Skripsi "created" event.
     */
    public function created(Skripsi $skripsi): void
    {
        SkripsiHistory::create([
            'skripsi_id' => $skripsi->id,
            'status'     => 'pending',
            'handler_id' => auth()->id(),
            'note'       => 'Pengajuan skripsi awal dikirim oleh mahasiswa.',
        ]);
    }

    /**
     * Handle the Skripsi "updated" event.
     */
    public function updated(Skripsi $skripsi): void
    {
        if ($skripsi->isDirty('status')) {
            $status = $skripsi->status;

            $note = null;
            if ($status === 'rejected') {
                $note = $skripsi->rejection_note ?? 'Pengajuan ditolak oleh Admin.';
            } elseif ($status === 'approved') {
                $note = 'Pengajuan disetujui oleh Admin.';
            } elseif ($status === 'pending') {
                $note = 'Pengajuan diajukan kembali.';
            }

            SkripsiHistory::create([
                'skripsi_id' => $skripsi->id,
                'status'     => $status,
                'handler_id' => auth()->id(),
                'note'       => $note,
            ]);
        }
    }
}
