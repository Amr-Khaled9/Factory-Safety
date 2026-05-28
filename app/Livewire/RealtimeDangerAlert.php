<?php

namespace App\Livewire;

use Livewire\Component;

class RealtimeDangerAlert extends Component
{
    public $notifications = [];

    public function loadNotifications()
    {
        $this->notifications =
            auth()
            ->user()
            ->unreadNotifications
            ->take(3);
    }
    public function render()
    {
        return view('livewire.realtime-danger-alert');
    }
}
