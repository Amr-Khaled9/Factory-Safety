@extends('layouts.app')

@section('title', 'Vehicles Management')

@section('content')

<link rel="stylesheet" href="{{ asset('css/vehicles.css') }}">

<section class="vehicles-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>

            <h1>Vehicles Management</h1>

            <p>
                Manage all registered vehicles
            </p>

        </div>

        <a
            href="{{ route('vehicles.create') }}"
            class="create-btn">

            <i class="fa-solid fa-plus"></i>

            Add Vehicle

        </a>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

    <div class="alert success-alert">

        {{ session('success') }}

    </div>

    @endif

    {{-- FILTERS --}}
    <div class="filter-buttons">

        <a
            href="{{ route('vehicles.index') }}"
            class="filter-btn">

            All Vehicles

        </a>

        <a
            href="{{ route('vehicles.authorized') }}"
            class="filter-btn green">

            Authorized

        </a>

        <a
            href="{{ route('vehicles.unauthorized') }}"
            class="filter-btn red">

            Unauthorized

        </a>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">

        <table class="vehicles-table">

            <thead>

                <tr>

                    <th>Image</th>

                    <th>Plate Number</th>

                    <th>Vehicle Type</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($vehicles as $vehicle)

                <tr>

                    {{-- IMAGE --}}
                    <td>

                        <img
                            src="{{ $vehicle->image }}"
                            alt="Vehicle"
                            class="vehicle-image">

                    </td>

                    {{-- PLATE --}}
                    <td>

                        {{ $vehicle->license_plate }}

                    </td>

                    {{-- TYPE --}}
                    <td>

                        {{ ucfirst($vehicle->vehicle_type) }}

                    </td>

                    {{-- STATUS --}}
                    <td>

                        @if($vehicle->authorized)

                        <span class="status authorized">

                            Authorized

                        </span>

                        @else

                        <span class="status unauthorized">

                            Unauthorized

                        </span>

                        @endif

                    </td>

                    {{-- ACTIONS --}}
                    <td>

                        <div class="actions-column">

                            <a
                                href="{{ route('vehicles.show', $vehicle->id) }}"
                                class="view-btn">

                                Show

                            </a>

                            <a
                                href="{{ route('vehicles.edit', $vehicle->id) }}"
                                class="edit-btn">

                                Edit

                            </a>

                            <form
                                action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                method="POST"
                                onsubmit="confirmDelete(event)">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-btn">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="empty">

                        No vehicles found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="pagination">

        {{ $vehicles->links() }}

    </div>

</section>

@endsection