<div wire:poll.2s="loadNotifications">

    @foreach($notifications as $notification)

    @php
    $peeId = $notification->data['pee_log_id'] ?? null;
    $vehicleId = $notification->data['vehicle_log_id'] ?? null;
    $fireId = $notification->data['fire_log_id'] ?? null; // ← زود دي
    @endphp

    <div
        class="danger-alert"
        x-data="{ show: true }"
        x-show="show"

        @click="
    window.location.href =
    '{{ $peeId
        ? '/detections/'.$peeId
        : ($fireId
            ? '/fire/'.$fireId
            : ($vehicleId ? '/gate/'.$vehicleId : '/gate')
        )
    }}'
">
        <strong>
            {{ $notification->data['title'] ?? 'No title' }}
        </strong>

        <p>
            {{ $notification->data['message'] ?? '' }}
        </p>

    </div>

    @endforeach

</div>