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
            'status_before' => null,
            'status_after' => 'pending',
            'handler_id' => auth()->id(),
            'note' => 'Pengajuan skripsi awal dikirim oleh mahasiswa.',
        ]);
    }

    /**
     * Handle the Skripsi "updated" event.
     */
    public function updated(Skripsi $skripsi): void
    {
        if ($skripsi->isDirty('status')) {
            $statusBefore = $skripsi->getOriginal('status');
            $statusAfter = $skripsi->status;

            $note = null;
            if ($statusAfter === 'rejected') {
                $note = $skripsi->rejection_note ?? 'Pengajuan ditolak oleh Admin.';
            } elseif ($statusAfter === 'approved') {
                $note = 'Pengajuan disetujui oleh Admin.';
            } elseif ($statusAfter === 'pending') {
                $note = 'Pengajuan diajukan kembali.';
            }

            SkripsiHistory::create([
                'skripsi_id' => $skripsi->id,
                'status_before' => $statusBefore,
                'status_after' => $statusAfter,
                'handler_id' => auth()->id(),
                'note' => $note,
            ]);
        }
    }
}
