<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Invitation extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('info@calendar.app')
            ->subject('Invitation to Calendar')
            ->greeting("Hello, {$this->user->name}!")
            ->line('To register in the service, please follow the link below.')
            ->action('Register', url('/?invitation_token='.urlencode($this->user->invitation_token)));
    }
}
