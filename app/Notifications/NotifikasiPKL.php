<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifikasiPKL extends Notification
{
    use Queueable;

    public $judul;
    public $pesan;
    public $link;

    public function __construct($judul, $pesan, $link = null)
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->link  = $link;
    }

    // KIRIM KE DATABASE + EMAIL
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    // EMAIL
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->judul)
            ->greeting('Halo ' . $notifiable->name)
            ->line($this->pesan)
            ->action('Buka Dashboard PKL', $this->link ?? url('/dashboard/mahasiswa'))
            ->line('Terima kasih telah menggunakan Sistem PKL.');
    }

    // DATABASE (UNTUK ICON LONCENG)
    public function toDatabase($notifiable)
    {
        return [
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'link'  => $this->link,
        ];
    }
}
