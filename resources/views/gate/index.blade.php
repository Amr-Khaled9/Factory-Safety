@extends('layouts.app')

@section('title', 'Gate Monitoring')

@section('content')

<section class="gate-page">

    <div class="page-header">

        <h1>Gate Monitoring</h1>

        <p>
            AI vehicle access monitoring system
        </p>

    </div>

    <div class="gate-grid">

        @foreach($logs as $log)

        <div class="gate-card">

            <img src="{{ $log->image }}" alt="vehicle">

            <div class="gate-content">

                <div class="status">

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

                <h3>
                    {{ $log->license_plate }}
                </h3>

                <div class="meta">

                    <span>
                        <i class="fa-regular fa-clock"></i>
                        {{ $log->created_at->diffForHumans() }}
                    </span>

                </div>

                <a href="{{ route('gate.show', $log->id) }}"
                    class="view-btn">

                    View Details

                </a>

            </div>

        </div>

        @endforeach

    </div>

</section>

@endsection