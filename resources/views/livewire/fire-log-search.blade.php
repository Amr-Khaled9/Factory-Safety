<section class="detections-page">

    <!-- Header -->
    <div class="page-header mb-4">
        <div>
            <h1 style="font-size:26px;font-weight:800;color:var(--text-primary);margin:0 0 4px">Fire Detections</h1>
            <p style="color:var(--text-muted);font-size:14px;margin:0">AI-detected fire & smoke incidents across all cameras</p>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-3">
            <input
                class="search-input"
                type="number"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by detection ID...">
        </div>

        <div class="col-md-3">
            <input
                class="form-control"
                type="date"
                wire:model.live="date">
        </div>

        <div class="col-md-3">
            <select class="form-control" wire:model.live="type">
                <option value="">All Types</option>
                <option value="fire">Fire</option>
                <option value="smoke">Smoke</option>
                <!-- <option value="other">Other</option> -->
            </select>
        </div>
    </div>

    <!-- Detection Grid -->
    <div class="detections-grid">

        @forelse($logs as $log)

        <div class="detection-card">

            @if($log->image)
                <img src="{{ $log->image }}" alt="Fire Detection">
            @else
                <div class="no-image">
                    <i class="fa-solid fa-fire fa-2x"></i>
                </div>
            @endif

            <div class="card-body">

                <span class="badge {{ $log->type === 'fire' ? 'bg-danger' : ($log->type === 'smoke' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                    <i class="fa-solid fa-{{ $log->type === 'fire' ? 'fire' : ($log->type === 'smoke' ? 'cloud' : 'circle-exclamation') }}"></i>
                    {{ strtoupper($log->type) }}
                </span>

                <h3>Detection #{{ $log->id }}</h3>

                <div class="meta">
                    <span><i class="fa-solid fa-camera"></i> Camera #{{ $log->number_camera ?? 'N/A' }}</span>
                    <span><i class="fa-solid fa-percent"></i> {{ number_format($log->confidence, 1) }}%</span>
                    <span><i class="fa-regular fa-clock"></i> {{ $log->created_at->diffForHumans() }}</span>
                </div>

                <a href="{{ route('fire.show', $log->id) }}" class="view-btn">
                    <i class="fa-solid fa-arrow-right me-2"></i>View Details
                </a>

            </div>

        </div>

        @empty

        <div class="empty-state">
            <i class="fa-solid fa-magnifying-glass"></i>
            No fire detections found.
        </div>

        @endforelse

    </div>

    <div class="pagination-wrapper">
        {{ $logs->links() }}
    </div>

</section>