<?php

namespace App\Notifications;

use App\Models\LogBook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LogBookReviewed extends Notification
{
    use Queueable;

    public function __construct(public LogBook $logBook)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title'       => $this->logBook->status === 'approved'
                ? 'Log Book Disetujui'
                : 'Log Book Ditolak',
            'message'     => sprintf(
                'Log book bimbingan tanggal %s telah %s oleh %s.',
                $this->logBook->date->format('d M Y'),
                $this->logBook->status === 'approved' ? 'disetujui' : 'ditolak',
                $this->logBook->lecturer->name ?? 'dosen pembimbing'
            ),
            'url'         => route('log-books.show', $this->logBook->id),
            'status'      => $this->logBook->status,
            'log_book_id' => $this->logBook->id,
        ];
    }
}
