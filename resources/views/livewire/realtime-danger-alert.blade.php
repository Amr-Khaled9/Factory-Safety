<div wire:poll.2s="loadNotifications">

    @foreach($notifications as $notification)

    <div
        class="danger-alert"

        x-data="{ show: true }"

        x-init="
                setTimeout(() => show = false, 5000)
            "

        x-show="show"

        @click="
                window.location.href =
                '{{ isset($notification->data['pee_log_id'])
                    ? '/detections/'.$notification->data['pee_log_id']
                    : '/gate/'.$notification->data['vehicle_log_id']
                }}'
            ">

        <strong>
            {{ $notification->data['title'] }}
        </strong>

        <p>
            {{ $notification->data['message'] }}
        </p>

    </div>

    @endforeach

</div>