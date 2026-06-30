@extends('layouts.app')

@section('title', 'Fire Detection Details')

@section('content')

<section class="detection-show">

    <div class="show-header">

        <div>
            <h1>Fire Detection #{{ $log->id }}</h1>
        </div>

        <span class="badge fs-6 px-3 py-2 
            {{ $log->type === 'fire' ? 'bg-danger' : ($log->type === 'smoke' ? 'bg-warning text-dark' : 'bg-secondary') }} text-white">
            {{ strtoupper($log->type) }}
        </span>

    </div>

    <div class="show-grid">

        <!-- IMAGE -->
        <div class="image-card">
            @if($log->image)
                <img src="{{ $log->image }}" alt="Fire Detection">
            @else
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <i class="fa-solid fa-image fa-3x"></i>
                </div>
            @endif
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
                    <span>Type</span>
                    <strong>{{ ucfirst($log->type) }}</strong>
                </div>

                <div class="info-item">
                    <span>Confidence</span>
                    <strong>{{ number_format($log->confidence, 2) }}%</strong>
                </div>

                <div class="info-item">
                    <span>Camera</span>
                    <strong>#{{ $log->number_camera ?? 'N/A' }}</strong>
                </div>

                <div class="info-item">
                    <span>Created At</span>
                    <strong>{{ $log->created_at }}</strong>
                </div>

                <div class="info-item">
                    <span>Last Update</span>
                    <strong>{{ $log->updated_at }}</strong>
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