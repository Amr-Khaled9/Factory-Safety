<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PEELogNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected $peeLog;

    public function __construct(string $title, string $message, $peeLog)
    {
        $this->title   = $title;
        $this->message = $message;
        $this->peeLog  = $peeLog;
    }

    /**
     * Notification channels
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * FCM notification
     */
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setNotification(FcmNotification::create([
                'title' => $this->title,
                'body' => $this->message,
            ]))
            ->setData([
                'type' => 'pee_log',
                'pee_log' => $this->peeLog->id,
                'click_action' => 'OPEN_PEE_LOG',
            ])
            ->setAndroid([
                'notification' => [
                    'sound' => 'default',
                    'channel_id' => 'pee_logs',
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
            'title'       => $this->title,
            'message'     => $this->message,
            'pee_log_id'  => $this->peeLog->id,
            'type'        => 'pee_log',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
            'type' => 'pee_log',
            'pee_log_id' => $this->peeLog->id,
        ]);
    }
}
