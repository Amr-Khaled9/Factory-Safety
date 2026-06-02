@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="p-4">
    <livewire:realtime-danger-alert />

    <!-- Title -->
    <div class="mb-4">
        <h1 class="fw-bold">Overview Dashboard</h1>
        <p class="text-muted">Real-time workplace safety metrics and AI detection summary.</p>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">

        <!-- Incidents -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon bg-danger text-white rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 65px; height: 65px; font-size: 24px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">{{ $todayAccidentCount }}</h2>
                        <h6 class="fw-semibold text-dark mb-1">Today's Incidents</h6>
                        <small class="text-muted">Total recorded violations today</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compliance -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon bg-primary text-white rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 65px; height: 65px; font-size: 24px;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">{{ $dailySafetyCompliance }}%</h2>
                        <h6 class="fw-semibold text-dark mb-1">Safety Compliance</h6>
                        <small class="text-muted">Overall workplace compliance rate</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitoring -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon bg-warning text-white rounded-3 d-flex align-items-center justify-content-center"
                         style="width: 65px; height: 65px; font-size: 24px;">
                        <i class="fa-solid fa-tower-broadcast"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">ONLINE</h2>
                        <h6 class="fw-semibold text-dark mb-1">AI Monitoring</h6>
                        <small class="text-muted">Detection systems operational</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="mb-3">
            <h2 class="fw-bold">Today's Safety Violations</h2>
            <p class="text-dark small">AI detection activity across all monitoring modules</p>
        </div>
        <canvas id="safetyChart" style="width: 100%; height: 380px;"></canvas>
    </div>

</section>

<!-- Send Data To JS -->
<script>
    window.chartData = @json($chartData);
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection