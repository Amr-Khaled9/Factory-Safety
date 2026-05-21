@extends('layouts.app')

@section('title', 'Safety Reports')

@section('content')

<section class="report-dashboard">

    <!-- HEADER + TOGGLE -->
    <div class="report-header">

        <h1>Safety Analytics Report</h1>
        <p>Daily & Weekly monitoring system</p>

        <div class="toggle">
            <button id="dailyBtn" class="active" onclick="showDaily()">Daily</button>
            <button id="weeklyBtn" onclick="showWeekly()">Weekly</button>
        </div>

    </div>

    <!-- ================= DAILY ================= -->
    <div id="daily">

        <!-- KPIs -->
        <div class="kpi-grid">

            <div class="kpi-card blue">
                <h2>{{ $daily['ppe_logs'] }}</h2>
                <p>PPE Logs</p>
            </div>

            <div class="kpi-card red">
                <h2>{{ $daily['vehicle_logs'] }}</h2>
                <p>Vehicle Logs</p>
            </div>

        </div>
        <br>

        <!-- BIG SECTION -->
        <div class="big-section">

            <div class="card full">

                <h3>Daily Safety Compliance</h3>

                <div class="progress-bar">
                    <div class="fill" style="width: {{ $dailyCompliance }}%"></div>
                </div>

                <h2>{{ $dailyCompliance }}%</h2>

            </div>

        </div>

    </div>

    <!-- ================= WEEKLY ================= -->
    <div id="weekly" style="display:none;">

        <!-- KPIs -->
        <div class="kpi-grid">

            <div class="kpi-card blue">
                <h2>{{ $weekly['ppe_logs'] }}</h2>
                <p>PPE Logs</p>
            </div>

            <div class="kpi-card red">
                <h2>{{ $weekly['vehicle_logs'] }}</h2>
                <p>Vehicle Logs</p>
            </div>

        </div>

        <!-- BIG SECTION -->
        <div class="big-section">

            <div class="card full">

                <h3>Weekly Safety Compliance</h3>

                <div class="progress-bar">
                    <div class="fill" style="width: {{ $weeklyCompliance }}%"></div>
                </div>

                <h2>{{ $weeklyCompliance }}%</h2>

            </div>

        </div>

    </div>

    <!-- INSIGHTS -->
    <div class="insight-box">

        <div class="risk">
            @if($dailyCompliance > 90)
            <span class="safe">LOW RISK</span>
            @elseif($dailyCompliance > 70)
            <span class="medium">MEDIUM RISK</span>
            @else
            <span class="high">HIGH RISK</span>
            @endif
        </div>

        <div class="breakdown">

            <div class="item">
                <span>PPE %</span>
                <strong>
                    {{ round(($daily['ppe_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%
                </strong>
            </div>

            <div class="item">
                <span>Vehicle %</span>
                <strong>
                    {{ round(($daily['vehicle_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%
                </strong>
            </div>

        </div>

    </div>

</section>

@endsection