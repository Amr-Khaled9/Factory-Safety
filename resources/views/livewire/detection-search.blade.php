<section class="detections-page">

    <input
        class="search-input"
        type="number"
        wire:model.live.debounce.300ms="search"
        placeholder="Search Detection ID">

    <!-- TOGGLES -->
    <div class="toggle-wrapper d-flex flex-wrap gap-2 mb-4">

        @foreach($ppeTypes as $index => $type)

        <button
            class="toggle-btn {{ $index === 0 ? 'active' : '' }}"
            data-target="{{ $type }}Section">

            <i class="fa-solid fa-shield-halved"></i>

            {{ ucfirst($type) }} Detection

        </button>

        @endforeach

    </div>

    <!-- PPE SECTIONS -->

    @foreach($ppeTypes as $index => $type)

    <div
        id="{{ $type }}Section"
        class="detections-grid"
        style="{{ $index !== 0 ? 'display:none;' : '' }}">

        @forelse($logs[$type] as $log)

        <div class="detection-card">

            <img
                src="{{ $log->image }}"
                alt="{{ $type }}">

            <div class="card-body">

                <span class="badge {{ $type }} text-danger">
                    {{ strtoupper($type) }}
                </span>

                <h3>
                    Detection #{{ $log->id }}
                </h3>

                <div class="meta">

                    <span>
                        <i class="fa-solid fa-camera"></i>
                        Camera #{{ $log->camera_id }}
                    </span>

                    <span>
                        <i class="fa-regular fa-clock"></i>
                        {{ $log->created_at->diffForHumans() }}
                    </span>

                </div>

                <a
                    href="{{ route('detections.show', $log->id) }}"
                    class="view-btn">

                    View Details

                </a>

            </div>

        </div>

        @empty

        <div class="empty-state">
            No detections found.
        </div>

        @endforelse

        <div class="pagination-wrapper">
            {{ $logs[$type]->links() }}
        </div>

    </div>

    @endforeach

</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const buttons = document.querySelectorAll('.toggle-btn');

        buttons.forEach(button => {

            button.addEventListener('click', () => {

                buttons.forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');

                document.querySelectorAll('.detections-grid')
                    .forEach(section => {
                        section.style.display = 'none';
                    });

                const target = button.dataset.target;

                document.getElementById(target).style.display = 'grid';
            });

        });

    });
</script>