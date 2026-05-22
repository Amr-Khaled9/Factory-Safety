<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->unreadNotifications
            ->take(10)
            ->toArray();
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        $this->loadNotifications();
    }

    public function getListeners()
    {
        return [
            "echo-private:App.Models.User." . Auth::id() . ",Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"
            => 'notificationReceived',
        ];
    }

    public function notificationReceived()
    {
        $this->loadNotifications();
    }


    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
