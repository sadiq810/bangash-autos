<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VoucherNotification extends Notification
{
    use Queueable;

    private $voucherCode,
            $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $amount)
    {
        $this->voucherCode = $code;
        $this->amount = $amount;
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
                    ->line('You have received a voucher, visit GulAutos.pk and apply below code at checkout page to avail discount of Pkr '.$this->amount)
                    ->line('Voucher Code: '. $this->voucherCode)
                    ->action('GulAutos.pk', url('/'))
                    ->line('Thank you for using our application!');
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
