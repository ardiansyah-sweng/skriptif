<?php

namespace App\Notifications;

use App\Models\Skripsi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewSkripsiSubmitted extends Notification
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
        return [
            'title'      => 'Pengajuan Skripsi Baru',
            'message'    => sprintf(
                '%s mengajukan skripsi dengan judul "%s", menunggu review Anda.',
                $this->skripsi->student->name ?? 'Mahasiswa',
                $this->skripsi->title
            ),
            'url'        => route('skripsi.index'),
            'skripsi_id' => $this->skripsi->id,
        ];
    }
}
