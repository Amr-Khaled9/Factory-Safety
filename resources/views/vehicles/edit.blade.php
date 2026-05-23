@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')


<section class="vehicle-form-page">

    <div class="vehicle-card">

        <div class="top-header">

            <h1>Edit Vehicle</h1>

            <a
                href="{{ route('vehicles.index') }}"
                class="back-btn">

                Back

            </a>

        </div>

        @if($errors->any())

        <div class="error-box">

            <ul>

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif

        <form
            action="{{ route('vehicles.update', $vehicle->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>
                    Plate Number
                </label>

                <input
                    type="text"
                    name="license_plate"
                    value="{{ old('license_plate', $vehicle->license_plate) }}">

            </div>

            <div class="form-group">

                <label>
                    Vehicle Type
                </label>

                <select name="vehicle_type">

                    <option value="car"
                        {{ $vehicle->vehicle_type == 'car' ? 'selected' : '' }}>
                        Car
                    </option>

                    <option value="truck"
                        {{ $vehicle->vehicle_type == 'truck' ? 'selected' : '' }}>
                        Truck
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>
                    Status
                </label>

                <select name="authorized">

                    <option
                        value="1"
                        {{ $vehicle->authorized ? 'selected' : '' }}>

                        Authorized

                    </option>

                    <option
                        value="0"
                        {{ !$vehicle->authorized ? 'selected' : '' }}>

                        Unauthorized

                    </option>

                </select>

            </div>
            <div class="current-image-box">

                <p class="current-image-title">
                    Current Vehicle Image
                </p>

                <img
                    src="{{ $vehicle->image }}"
                    alt="Vehicle Image"
                    class="current-vehicle-image">

            </div>

            <div class="form-group">

                <label>
                    Vehicle Image
                </label>

                <input
                    type="file"
                    name="image">

            </div>

            <button
                type="submit"
                class="save-btn">

                Update Vehicle

            </button>

        </form>

    </div>

</section>

@endsection