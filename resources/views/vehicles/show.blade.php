@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')


<section class="vehicle-form-page">

    <div class="vehicle-card">

        <div class="top-header">

            <h1>Vehicle Details</h1>

            <a
                href="{{ route('vehicles.index') }}"
                class="back-btn">

                Back

            </a>

        </div>

        <img
            src="{{ $vehicle->image }}"
            class="vehicle-preview">

        <div class="details-grid">

            <div class="detail-box">

                <span>Plate Number</span>

                <h3>
                    {{ $vehicle->license_plate }}
                </h3>

            </div>

            <div class="detail-box">

                <span>Vehicle Type</span>

                <h3>
                    {{ ucfirst($vehicle->vehicle_type) }}
                </h3>

            </div>

            <div class="detail-box">

                <span>Status</span>

                <h3>

                    @if($vehicle->authorized)

                    Authorized

                    @else

                    Unauthorized

                    @endif

                </h3>

            </div>

        </div>

    </div>

</section>

@endsection