<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Inscricao;

class ConfirmarInscricaoNotification extends Notification
{
    use Queueable;

    public $inscricao;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Inscricao $inscricao)
    {
        $this->inscricao = $inscricao;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'emails.confirmar_inscricao',
            ['inscricao' => $this->inscricao]
        );
        // ->line('The introduction to the notification.')
        // ->action('Notification Action', url('/'))
        // ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
