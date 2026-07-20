<?php

namespace App\Notifications;

use App\Models\Skripsi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SkripsiStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Skripsi $skripsi)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $statusText = match ($this->skripsi->status) {
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            default    => $this->skripsi->status,
        };

        return [
            'title'      => 'Status Pengajuan Skripsi Diperbarui',
            'message'    => sprintf('Judul "%s" telah %s.', $this->skripsi->title, $statusText),
            'url'        => route('student.skripsi.history'),
            'status'     => $this->skripsi->status,
            'skripsi_id' => $this->skripsi->id,
        ];
    }
}
