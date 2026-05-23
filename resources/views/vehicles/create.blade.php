@extends('layouts.app')

@section('title', 'Create Vehicle')

@section('content')


<section class="vehicle-form-page">

    <div class="vehicle-card">

        <div class="top-header">

            <h1>Create Vehicle</h1>

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
            action="{{ route('vehicles.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label>
                    Plate Number
                </label>

                <input
                    type="text"
                    name="license_plate"
                    value="{{ old('license_plate') }}"
                    placeholder="Enter plate number">

            </div>

            <div class="form-group">

                <label>
                    Vehicle Type
                </label>

                <select name="vehicle_type">

                    <option value="">
                        Select Vehicle Type
                    </option>

                    <option
                        value="car"
                        {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>

                        Car

                    </option>

                    <option
                        value="truck"
                        {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>

                        Truck

                    </option>


                </select>

            </div>

            <div class="form-group">

                <label>
                    Status
                </label>

                <select name="authorized">

                    <option value="1">
                        Authorized
                    </option>

                    <option value="0">
                        Unauthorized
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>
                    Vehicle Image
                </label>

                <input
                    type="file"
                    name="image"
                    id="imageInput">

            </div>

            <!-- IMAGE PREVIEW -->

            <div
                class="image-preview-box"
                id="previewBox">

                <p class="preview-title">
                    Image Preview
                </p>

                <img
                    id="previewImage"
                    class="preview-image">

            </div>

            <button
                type="submit"
                class="save-btn">

                Create Vehicle

            </button>

        </form>

    </div>

</section>

<script>
    const imageInput = document.getElementById('imageInput');

    const previewImage = document.getElementById('previewImage');

    const previewBox = document.getElementById('previewBox');

    imageInput.addEventListener('change', function(e) {

        const file = e.target.files[0];

        if (file) {

            previewImage.src = URL.createObjectURL(file);

            previewBox.style.display = 'block';
        }
    });
</script>

@endsection