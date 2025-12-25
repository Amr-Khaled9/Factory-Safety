<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class PEELogNotification extends Notification
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
        return ['database', FcmChannel::class];
    }

    /**
     * FCM notification
     */
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setNotification(
                FcmNotification::create()
                    ->setTitle($this->title)
                    ->setBody($this->message)
            )
            ->setData([
                'type'       => 'pee_log',
                'pee_log' => $this->peeLog->id,
                'click_action' => 'OPEN_PEE_LOG',
            ])
            ->setCustom([
                'android' => [
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'pee_logs',
                        'color' => '#ff0000ff',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'badge' => 1,
                        ],
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
}
