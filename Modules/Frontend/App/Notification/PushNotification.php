<?php

namespace Modules\Frontend\App\Notification;

use Illuminate\Bus\Queueable;
use Modules\Frontend\App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Admin\App\Models\Admin;

class PushNotification extends Notification
{
    use Queueable;

    private $user;
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User|Admin $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->user->name . ' have messaged you!')
            ->icon("image/notify.png")
            ->body($this->message)
            ->action('View Message', 'view_message')
            ->image('image/icons/icon-128x128.png')
            ->vibrate([300, 100, 400]);
    }
}
