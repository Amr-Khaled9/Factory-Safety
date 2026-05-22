@extends('layouts.app')

@section('title', 'Gate Details')

@section('content')

<section class="gate-show">

    <div class="show-header">

        <div>

            <h1>
                Vehicle #{{ $log->id }}
            </h1>

            <p>

            </p>

        </div>

        @if($log->authorized)

        <span class="authorized">
            Authorized
        </span>

        @else

        <span class="unauthorized">
            Unauthorized
        </span>

        @endif

    </div>

    <div class="show-grid">

        <div class="image-card">

            <img src="{{ $log->image }}" alt="vehicle">

        </div>

        <div class="details-card">

            <h2>Vehicle Information</h2>

            <div class="info-list">

                <div class="info-item">
                    <span>License Plate</span>
                    <strong>{{ $log->license_plate }}</strong>
                </div>

                <div class="info-item">
                    <span>Status</span>

                    <strong>

                        {{ $log->authorized ? 'Authorized' : 'Unauthorized' }}

                    </strong>
                </div>

                <div class="info-item">
                    <span>Created At</span>
                    <strong>{{ $log->created_at }}</strong>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection