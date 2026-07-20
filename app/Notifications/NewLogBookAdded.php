<?php

namespace App\Notifications;

use App\Models\LogBook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLogBookAdded extends Notification
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
            'title'       => 'Log Book Baru Ditambahkan',
            'message'     => sprintf(
                'Log book bimbingan tanggal %s bersama %s telah dicatat (status: %s).',
                $this->logBook->date->format('d M Y'),
                $this->logBook->lecturer->name ?? 'dosen pembimbing',
                $this->logBook->status
            ),
            'url'         => route('log-books.show', $this->logBook->id),
            'log_book_id' => $this->logBook->id,
        ];
    }
}
