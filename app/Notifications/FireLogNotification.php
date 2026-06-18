<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FireLogNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected $fireLog;

    public function __construct(string $title, string $message, $fireLog)
    {
        $this->title   = $title;
        $this->message = $message;
        $this->fireLog = $fireLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setNotification(FcmNotification::create([
                'title' => $this->title,
                'body' => $this->message,
            ]))
            ->setData([
                'type' => 'fire_log',
                'fire_log' => $this->fireLog->id,
                'click_action' => 'OPEN_FIRE_LOG',
            ])
            ->setAndroid([
                'notification' => [
                    'sound' => 'default',
                    'channel_id' => 'fire_logs',
                    'color' => '#ff0000ff',
                ],
            ])
            ->setApns([
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'badge' => 1,
                    ],
                ],
            ]);
    }

    /**
     * Database notification
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'fire_log_id' => $this->fireLog->id,
            'type' => 'fire_log',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
            'type' => 'fire_log',
            'fire_log_id' => $this->fireLog->id,
        ]);
    }
}