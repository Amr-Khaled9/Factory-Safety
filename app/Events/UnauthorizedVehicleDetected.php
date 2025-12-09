<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UnauthorizedVehicleDetected  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $notificationTitle, public $notificationMessage, public $adminId)
    {
        //
        Log::info("UnauthorizedVehicleDetected Event created for admin ID: {$this->adminId}, {$this->notificationTitle},{$this->notificationMessage}");
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.' . $this->adminId),
        ];
    }
    public function broadcastWith(): array
    {
        return [
            'notificationTitle' => $this->notificationTitle,
            'notificationMessage' => $this->notificationMessage,
            'adminId' =>  $this->adminId
        ];
    }
}
