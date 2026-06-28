<section class="gate-page">

    <div class="page-header">
        <div>
            <h1>Gate Monitoring</h1>
            <p>AI vehicle access monitoring system</p>
        </div>
    </div>

    <div class="search-box">
        <input
            type="text"
            class="search-input"
            placeholder="Search by license plate..."
            wire:model.live="search">
    </div>

    <div class="gate-grid">

        @foreach($logs as $log)

        <div class="gate-card">

            <img src="{{ $log->image }}" alt="Vehicle {{ $log->license_plate }}">

            <div class="gate-content">

                <div class="status">
                    @if($log->authorized)
                    <span class="authorized">
                        <i class="fa-solid fa-circle-check"></i>
                        Authorized
                    </span>
                    @else
                    <span class="unauthorized">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Unauthorized
                    </span>
                    @endif
                </div>

                <h3>{{ $log->license_plate }}</h3>

                <div class="meta">
                    <span><i class="fa-regular fa-clock"></i> {{ $log->created_at->diffForHumans() }}</span>
                </div>

                <a href="{{ route('gate.show', $log->id) }}" class="view-btn">
                    <i class="fa-solid fa-arrow-right me-2"></i>View Details
                </a>

            </div>

        </div>

        @endforeach

    </div>

    <div class="pagination-wrapper">
        {{ $logs->links() }}
    </div>

</section>