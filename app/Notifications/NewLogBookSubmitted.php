<?php

namespace App\Notifications;

use App\Models\LogBook;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLogBookSubmitted extends Notification
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
        $suffix = $this->logBook->status === 'pending'
            ? ', menunggu review Anda.'
            : sprintf(' (status: %s).', $this->logBook->status);

        return [
            'title'       => 'Log Book Baru',
            'message'     => sprintf(
                'Log book bimbingan %s tanggal %s telah dicatat%s',
                $this->logBook->student->name ?? 'mahasiswa',
                $this->logBook->date->format('d M Y'),
                $suffix
            ),
            'url'         => route('log-books.show', $this->logBook->id),
            'log_book_id' => $this->logBook->id,
        ];
    }
}
