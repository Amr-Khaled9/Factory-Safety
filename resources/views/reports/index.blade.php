@extends('layouts.app')

@section('title', 'Safety Reports')

@section('content')

<section class="p-4">

    <!-- HEADER + TOGGLE -->
    <div class="mb-4">

        <h1 class="fw-bold">Safety Analytics Report</h1>
        <p class="text-muted">Daily & Weekly monitoring system</p>

        <div class="d-flex gap-2 mt-3">
            <button id="dailyBtn" class="btn btn-primary btn-sm" onclick="showDaily()">Daily</button>
            <button id="weeklyBtn" class="btn btn-light btn-sm" onclick="showWeekly()">Weekly</button>
        </div>

    </div>

    <!-- ================= DAILY ================= -->
    <div id="daily">

        <!-- KPIs -->
        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 text-center p-4 border-start border-primary border-4">
                    <h2 class="fw-bold">{{ $daily['ppe_logs'] }}</h2>
                    <p class="text-muted mb-0">PPE Logs</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 text-center p-4 border-start border-danger border-4">
                    <h2 class="fw-bold">{{ $daily['vehicle_logs'] }}</h2>
                    <p class="text-muted mb-0">Vehicle Logs</p>
                </div>
            </div>

        </div>

        <!-- BIG SECTION -->
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">

            <h3 class="fw-semibold mb-3">Daily Safety Compliance</h3>

            <div class="progress rounded-3" style="height: 20px;">
                <div class="progress-bar bg-gradient" role="progressbar"
                     style="width: {{ $dailyCompliance }}%; background: linear-gradient(90deg, #1e88ff, #00c6ff);"
                     aria-valuenow="{{ $dailyCompliance }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <h2 class="fw-bold mt-3">{{ $dailyCompliance }}%</h2>

        </div>

    </div>

    <!-- ================= WEEKLY ================= -->
    <div id="weekly" style="display:none;">

        <!-- KPIs -->
        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 text-center p-4 border-start border-primary border-4">
                    <h2 class="fw-bold">{{ $weekly['ppe_logs'] }}</h2>
                    <p class="text-muted mb-0">PPE Logs</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 text-center p-4 border-start border-danger border-4">
                    <h2 class="fw-bold">{{ $weekly['vehicle_logs'] }}</h2>
                    <p class="text-muted mb-0">Vehicle Logs</p>
                </div>
            </div>

        </div>

        <!-- BIG SECTION -->
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">

            <h3 class="fw-semibold mb-3">Weekly Safety Compliance</h3>

            <div class="progress rounded-3" style="height: 20px;">
                <div class="progress-bar bg-gradient" role="progressbar"
                     style="width: {{ $weeklyCompliance }}%; background: linear-gradient(90deg, #1e88ff, #00c6ff);"
                     aria-valuenow="{{ $weeklyCompliance }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <h2 class="fw-bold mt-3">{{ $weeklyCompliance }}%</h2>

        </div>

    </div>

    <!-- INSIGHTS -->
    <div class="card border-0 shadow-sm rounded-3 p-4 mt-4">

        <div class="mb-3">
            @if($dailyCompliance > 90)
            <span class="badge bg-success fs-6">LOW RISK</span>
            @elseif($dailyCompliance > 70)
            <span class="badge bg-warning text-dark fs-6">MEDIUM RISK</span>
            @else
            <span class="badge bg-danger fs-6">HIGH RISK</span>
            @endif
        </div>

        <div class="row text-center">

            <div class="col-6">
                <span class="text-muted d-block">PPE %</span>
                <strong>
                    {{ round(($daily['ppe_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%
                </strong>
            </div>

            <div class="col-6">
                <span class="text-muted d-block">Vehicle %</span>
                <strong>
                    {{ round(($daily['vehicle_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%
                </strong>
            </div>

        </div>

    </div>

</section>

@endsection