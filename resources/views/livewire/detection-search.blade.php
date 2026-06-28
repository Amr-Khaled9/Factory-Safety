<section class="detections-page">

    <!-- Header -->
    <div class="page-header mb-4">
        <div>
            <h1 style="font-size:26px;font-weight:800;color:var(--text-primary);margin:0 0 4px">PPE Detections</h1>
            <p style="color:var(--text-muted);font-size:14px;margin:0">AI-detected safety violations across all cameras</p>
        </div>
    </div>

    <!-- Search -->
    <input
        class="search-input"
        type="number"
        wire:model.live.debounce.300ms="search"
        placeholder="Search by detection ID...">

    <!-- Toggle Buttons -->
    <div class="toggle-wrapper">
        @foreach($ppeTypes as $index => $type)
        <button
            class="toggle-btn {{ $index === 0 ? 'active' : '' }}"
            data-target="{{ $type }}Section">
            <i class="fa-solid fa-hard-hat me-2"></i>
            {{ ucfirst($type) }}
        </button>
        @endforeach
    </div>

    <!-- Detection Grids -->
    @foreach($ppeTypes as $index => $type)

    <div id="{{ $type }}Section"
         class="detections-grid"
         style="{{ $index !== 0 ? 'display:none;' : '' }}">

        @forelse($logs[$type] as $log)

        <div class="detection-card">

            <img src="{{ $log->image }}" alt="{{ $type }}">

            <div class="card-body">

                <span class="badge {{ $type }}">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ strtoupper($type) }}
                </span>

                <h3>Detection #{{ $log->id }}</h3>

                <div class="meta">
                    <span><i class="fa-solid fa-camera"></i> Camera #{{ $log->camera_id }}</span>
                    <span><i class="fa-regular fa-clock"></i> {{ $log->created_at->diffForHumans() }}</span>
                </div>

                <a href="{{ route('detections.show', $log->id) }}" class="view-btn">
                    <i class="fa-solid fa-arrow-right me-2"></i>View Details
                </a>

            </div>

        </div>

        @empty

        <div class="empty-state">
            <i class="fa-solid fa-magnifying-glass"></i>
            No {{ $type }} detections found.
        </div>

        @endforelse

        <div class="pagination-wrapper" style="grid-column:1/-1">
            {{ $logs[$type]->links() }}
        </div>

    </div>

    @endforeach

</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.toggle-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.detections-grid').forEach(s => s.style.display = 'none');
            document.getElementById(btn.dataset.target).style.display = 'grid';
        });
    });
});
</script>