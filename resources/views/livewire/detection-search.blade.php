<section class="detections-page">

    <input class="search-input"
        type="number"
        wire:model.live.debounce.300ms="search"
        placeholder="Search Detection ID">

    <!-- TOGGLE -->
    <div class="toggle-wrapper">

        <button class="toggle-btn active" id="vestBtn">
            <i class="fa-solid fa-user-check"></i>
            Vest Detection
        </button>

        <button class="toggle-btn" id="helmetBtn">
            <i class="fa-solid fa-hard-hat"></i>
            Helmet Detection
        </button>

    </div>

    <!-- VEST -->
    <div id="vestSection" class="detections-grid">

        @foreach($vesteLogs as $log)
        <div class="detection-card">

            <img src="{{ $log->image }}" alt="vest">

            <div class="card-body">

                <span class="badge vest">VEST</span>

                <h3>Detection #{{ $log->id }}</h3>

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

                <a href="{{ route('detections.show', $log->id) }}"
                    class="view-btn">
                    View Details
                </a>

            </div>
        </div>
        @endforeach
        <!-- pagination vest -->
        <div class="pagination-wrapper">
            {{ $vesteLogs->links() }}
        </div>
    </div>

    <!-- HELMET -->
    <div id="helmetSection" class="detections-grid" style="display:none;">

        @foreach($helmetLogs as $log)
        <div class="detection-card">

            <img src="{{ $log->image }}" alt="helmet">

            <div class="card-body">

                <span class="badge helmet">HELMET</span>

                <h3>Detection #{{ $log->id }}</h3>

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

                <a href="{{ route('detections.show', $log->id) }}"
                    class="view-btn">
                    View Details
                </a>

            </div>
        </div>
        @endforeach
        <!-- pagination helmet -->
        <div class="pagination-wrapper">
            {{ $helmetLogs->links() }}
        </div>

    </div>


</section>