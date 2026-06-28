@extends('layouts.app')

@section('title', 'Vehicle Details')
@section('page-title', 'Vehicle Details')
@section('page-subtitle', 'Registered vehicle information')

@section('content')

<section class="vehicle-form-page">

    <div class="vehicle-card">

        <div class="top-header">
            <h1>Vehicle Details</h1>
            <a href="{{ route('vehicles.index') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
        </div>

        <img src="{{ $vehicle->image }}" class="vehicle-preview" alt="Vehicle {{ $vehicle->license_plate }}">

        <div class="details-grid">

            <div class="detail-box">
                <span>Plate Number</span>
                <h3 style="font-family:var(--mono);letter-spacing:2px">{{ $vehicle->license_plate }}</h3>
            </div>

            <div class="detail-box">
                <span>Vehicle Type</span>
                <h3>{{ ucfirst($vehicle->vehicle_type) }}</h3>
            </div>

            <div class="detail-box">
                <span>Access Status</span>
                <h3>
                    @if($vehicle->authorized)
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
                </h3>
            </div>

        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('vehicles.edit', $vehicle) }}"
               class="save-btn text-center text-decoration-none d-flex align-items-center justify-content-center gap-2"
               style="flex:1;background:var(--dark-surface);border:1px solid var(--dark-border)">
                <i class="fa-solid fa-pen"></i>Edit
            </a>
            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                  onsubmit="return confirm('Delete this vehicle?')" style="flex:1">
                @csrf
                @method('DELETE')
                <button type="submit" class="save-btn w-100 d-flex align-items-center justify-content-center gap-2"
                        style="background:var(--danger)">
                    <i class="fa-solid fa-trash"></i>Delete
                </button>
            </form>
        </div>

    </div>

</section>

@endsection