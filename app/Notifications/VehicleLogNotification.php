<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;


class VehicleLogNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected $vehicleLog;

    public function __construct(string $title, string $message, $vehicleLog)
    {
        $this->title   = $title;
        $this->message = $message;
        $this->vehicleLog  = $vehicleLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
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
                'type' => 'vehicle_log',
                'vehicle_log' => $this->vehicleLog->id,
                'click_action' => 'OPEN_VEHICLE_LOG',
            ])
            ->setAndroid([
                'notification' => [
                    'sound' => 'default',
                    'channel_id' => 'vehicle_logs',
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
            'pee_log_id'  => $this->vehicleLog->id,
            'type'        => 'vehicle_log',
        ];
    }
}
