@extends('layouts.app')

@section('title', 'Gate Details')
@section('page-title', 'Gate Log Details')
@section('page-subtitle', 'AI vehicle access event')

@section('content')

<section class="detection-show">

    <div class="show-header">

        <div>
            <h1>Vehicle #{{ $log->id }}</h1>
            <p>Recorded {{ $log->created_at->format('d M Y, H:i') }}</p>
        </div>

        @if($log->authorized)
        <span class="authorized" style="font-size:14px;padding:10px 18px">
            <i class="fa-solid fa-circle-check"></i>
            Authorized
        </span>
        @else
        <span class="unauthorized" style="font-size:14px;padding:10px 18px">
            <i class="fa-solid fa-circle-xmark"></i>
            Unauthorized
        </span>
        @endif

    </div>

    <div class="show-grid">

        <div class="image-card">
            <img src="{{ $log->image }}" alt="Vehicle {{ $log->license_plate }}">
        </div>

        <div class="details-card">

            <h2>Vehicle Information</h2>

            <div class="info-list">

                <div class="info-item">
                    <span>License Plate</span>
                    <strong style="font-family:var(--mono);letter-spacing:2px">
                        {{ $log->license_plate }}
                    </strong>
                </div>

                <div class="info-item">
                    <span>Access Status</span>
                    <strong>
                        @if($log->authorized)
                        <span class="authorized" style="font-size:12px;padding:4px 10px">
                            <i class="fa-solid fa-circle-check"></i> Authorized
                        </span>
                        @else
                        <span class="unauthorized" style="font-size:12px;padding:4px 10px">
                            <i class="fa-solid fa-circle-xmark"></i> Unauthorized
                        </span>
                        @endif
                    </strong>
                </div>

                <div class="info-item">
                    <span>Detected At</span>
                    <strong>{{ $log->created_at->format('d M Y, H:i:s') }}</strong>
                </div>

                <div class="info-item">
                    <span>Time Ago</span>
                    <strong>{{ $log->created_at->diffForHumans() }}</strong>
                </div>

            </div>

            <div class="action-buttons">
                <a href="{{ route('gate.index') }}"
                   class="primary-btn text-decoration-none">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Gate Log
                </a>
            </div>

        </div>

    </div>

</section>

@endsection