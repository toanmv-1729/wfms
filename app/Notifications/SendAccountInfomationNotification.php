<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendAccountInfomationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $username;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
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
            ->subject(Lang::getFromJson('Account Infomation Notification'))
            ->line(Lang::getFromJson('You are receiving this email because we created your account. Check your infomation below.'))
            ->line(Lang::getFromJson('Your Username: ' . $this->username))
            ->line(Lang::getFromJson('Your Password: ' . $this->password))
            ->action(Lang::getFromJson('Access Your Account Here'), url(config('app.url')))
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
