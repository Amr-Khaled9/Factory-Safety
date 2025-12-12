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

class PEEDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $notificationTitle, public $notificationMessage, public $adminId)
    {
        //
        Log::info("UnauthorizedVehicleDetected Event created for admin ID: {$this->adminId}, {$this->notificationTitle},{$this->notificationMessage}");
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('usersPee.' . $this->adminId),
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
