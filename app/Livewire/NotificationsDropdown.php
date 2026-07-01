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

    public $unreadCount = 0;
    public $isLoaded = false;

    public function loadNotifications()
    {
        $newCount = Auth::user()->unreadNotifications()->count();

        // If the count increases, it means a new notification arrived!
        if ($this->isLoaded && $newCount > $this->unreadCount) {
            $this->dispatch('play-sound');
        }
        
        $this->unreadCount = $newCount;
        $this->isLoaded = true;

        $this->notifications = Auth::user()
            ->unreadNotifications
            // ->take(10)
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
