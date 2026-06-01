<div wire:poll.1s="notificationReceived"
    x-data="{ open: false }"
    class="notification-wrapper">

    <!-- BUTTON -->
    <button
        class="notification-btn"
        @click="open = !open">
        <i class="fa-regular fa-bell"></i>

        @if(count($notifications) > 0)
        <span class="notification-count">
            {{ count($notifications) }}
        </span>
        @endif
    </button>

    <!-- DROPDOWN -->
    <div
        x-show="open"
        @click.outside="open = false"
        class="notifications-dropdown"
        x-transition>

        <div class="dropdown-header">

            <h3>Notifications</h3>

            @if(count($notifications) > 0)

            <button
                wire:click="markAllAsRead"
                class="mark-read-btn">
                Mark all as read
            </button>

            @endif

        </div>

        @forelse($notifications as $notification)

        @php
        $url = '#';

        if (($notification['data']['type'] ?? null) === 'vehicle_log') {
        $url = route('gate.show', $notification['data']['vehicle_log_id']);
        }

        if (($notification['data']['type'] ?? null) === 'pee_log') {
        $url = route('detections.show', $notification['data']['pee_log_id']);
        }
        @endphp

        <a href="{{ $url }}" class="notification-item">

            <div class="notification-content">

                <h4>
                    {{ $notification['data']['title'] ?? '' }}
                </h4>

                <p>
                    {{ $notification['data']['message'] ?? '' }}
                </p>

            </div>

        </a>

        @empty

        <div class="empty-notifications">
            No notifications
        </div>

        @endforelse

    </div>

</div>