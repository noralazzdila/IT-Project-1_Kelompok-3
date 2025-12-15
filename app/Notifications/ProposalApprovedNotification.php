<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $status)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // <— Email + Database
    }

    public function toMail($notifiable)
    {
        $judul = $this->status === 'approved'
            ? 'Proposal Anda Disetujui'
            : 'Proposal Anda Ditolak';

        $pesan = $this->status === 'approved'
            ? 'Proposal PKL Anda telah disetujui.'
            : 'Proposal PKL Anda ditolak. Silakan perbaiki dan ajukan lagi.';

        return (new MailMessage)
            ->subject($judul)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line($pesan)
            ->action('Lihat Proposal', url('/mahasiswa/proposal'))
            ->line('Terima kasih.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Status Proposal PKL',
            'message' =>
                $this->status === 'approved'
                    ? 'Proposal disetujui.'
                    : 'Proposal ditolak.',
        ];
    }
}
