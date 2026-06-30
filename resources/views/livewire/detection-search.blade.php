<section class="detections-page">

    <!-- Header -->
    <div class="page-header mb-4">
        <div>
            <h1 style="font-size:26px;font-weight:800;color:var(--text-primary);margin:0 0 4px">PPE Detections</h1>
            <p style="color:var(--text-muted);font-size:14px;margin:0">AI-detected safety violations across all cameras</p>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-6">
        <div class="col-md-4">
            <input
                class="search-input"
                type="number"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by detection ID...">
        </div>

        <div class="col-md-6">
            <input
                class="form-control"
                type="date"
                wire:model.live="date">
        </div>
    </div>

    <!-- Detection Grid -->
    <div class="detections-grid">

        @forelse($logs as $log)

        @php
        $violationsList = is_array($log->violations)
        ? $log->violations
        : (json_decode($log->violations, true) ?? []);
        @endphp

        <div class="detection-card">

            <img src="{{ $log->image }}" alt="PPE Violation">

            <div class="card-body">

                @foreach($violationsList as $violation)
                <span class="badge {{ $violation }}">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ strtoupper($violation) }}
                </span>
                @endforeach

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
            No detections found.
        </div>

        @endforelse

    </div>

    <div class="pagination-wrapper">
        {{ $logs->links() }}
    </div>

</section>