@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="dashboard">
    <livewire:realtime-danger-alert />
    <!-- Title -->
    <div class="title">
        <h1>Overview Dashboard</h1>
        <p>Real-time workplace safety metrics and AI detection summary.</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">

        <!-- Incidents -->
        <div class="card">

            <div class="card-icon red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="card-info">
                <h2>{{ $todayAccidentCount }}</h2>
                <h4>Today's Incidents</h4>
                <p>Total recorded violations today</p>
            </div>

        </div>

        <!-- Compliance -->
        <div class="card">

            <div class="card-icon blue">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <div class="card-info">
                <h2>{{ $dailySafetyCompliance }}%</h2>
                <h4>Safety Compliance</h4>
                <p>Overall workplace compliance rate</p>
            </div>

        </div>

        <!-- Monitoring -->
        <div class="card">

            <div class="card-icon orange">
                <i class="fa-solid fa-tower-broadcast"></i>
            </div>

            <div class="card-info">
                <h2>ONLINE</h2>
                <h4>AI Monitoring</h4>
                <p>Detection systems operational</p>
            </div>

        </div>

    </div>

    <!-- Chart -->
    <div class="chart-container">

        <div class="chart-header">
            <h2>Today's Safety Violations</h2>
            <p>AI detection activity across all monitoring modules</p>
        </div>

        <canvas id="safetyChart"></canvas>

    </div>


</section>

<!-- Send Data To JS -->
<script>
    window.chartData = @json($chartData);
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection