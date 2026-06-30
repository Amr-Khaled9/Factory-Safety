@extends('layouts.app')

@section('title', 'Detection Details')

@section('content')

<section class="detection-show">

    <!-- HEADER -->

    @php
        $violationsList = is_array($log->violations)
            ? $log->violations
            : (json_decode($log->violations, true) ?? []);
    @endphp

    <div class="show-header">

        <div>

            <h1>
                Detection #{{ $log->id }}
            </h1>

            <p>

            </p>

        </div>

        @foreach($violationsList as $violation)
<span class="badge bg-danger text-white fs-6 px-3 py-2">
    {{ strtoupper($violation) }}
</span>
        @endforeach

    </div>

    <!-- CONTENT -->

    <div class="show-grid">

        <!-- IMAGE -->

        <div class="image-card">

            <img src="{{ $log->image }}" alt="Detection">

        </div>

        <!-- DETAILS -->

        <div class="details-card">

            <h2>Detection Information</h2>

            <div class="info-list">

                <div class="info-item">
                    <span>ID</span>
                    <strong>#{{ $log->id }}</strong>
                </div>

                <div class="info-item">
                    <span>PPE Violations</span>
                    <strong>
                        {{ implode(', ', $violationsList) }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>Camera ID</span>
                    <strong>
                        #{{ $log->camera_id }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>Person ID</span>
                    <strong>
                        #{{ $log->person_id }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>Created At</span>
                    <strong>
                        {{ $log->created_at }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>Last Update</span>
                    <strong>
                        {{ $log->updated_at }}
                    </strong>
                </div>

            </div>

            <div class="action-buttons">

                <button class="primary-btn">
                    <i class="fa-solid fa-check"></i>
                    Mark as Reviewed
                </button>

                <button class="danger-btn">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Send Alert
                </button>

            </div>

        </div>

    </div>

</section>

@endsection