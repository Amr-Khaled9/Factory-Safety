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
        style="max-height:400px;overflow-y:auto"
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
        $data = $notification['data'] ?? [];
        $url = '#';

        if (($data['type'] ?? null) === 'vehicle_log') {
        $url = isset($data['vehicle_log_id'])
        ? route('gate.show', $data['vehicle_log_id'])
        : '#';
        }

        if (($data['type'] ?? null) === 'pee_log') {
        $url = isset($data['pee_log_id'])
        ? route('detections.show', $data['pee_log_id'])
        : '#';
        }

        if (($data['type'] ?? null) === 'fire_log') {
        $url = isset($data['fire_log_id'])
        ? route('fire.show', $data['fire_log_id'])
        : '#';
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