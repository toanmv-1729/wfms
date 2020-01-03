<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdatedTicketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticketId;
    protected $ticketTitle;
    protected $ticketType;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticketId, $ticketType, $ticketTitle)
    {
        $this->ticketId = $ticketId;
        $this->ticketTitle = $ticketTitle;
        $this->ticketType = $ticketType;
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
        return (new MailMessage)
            ->subject(Lang::getFromJson('Ticket Updated Notification'))
            ->line(Lang::getFromJson('Ticket #' . $this->ticketId . ' has been updated. You are receiving this email because you has been assigned ticket'))
            ->line(Lang::getFromJson($this->ticketType . '#' . $this->ticketId . ': ' . $this->ticketTitle))
            ->action(Lang::getFromJson('Access Your Ticket Here'), url(config('app.url') . route('tickets.show', $this->ticketId, false)))
            ->line(Lang::getFromJson('Thank you for using our platform!'));
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
