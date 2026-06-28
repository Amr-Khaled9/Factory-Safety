@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview Dashboard')
@section('page-subtitle', 'Real-time workplace safety metrics and AI detection summary')

@section('content')

<section class="p-4">

    <livewire:realtime-danger-alert />

    <!-- Stats -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon bg-danger text-white rounded-3"
                         style="width:52px;height:52px;font-size:20px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:28px;line-height:1">{{ $todayAccidentCount }}</div>
                        <div class="fw-semibold" style="font-size:14px;margin-top:2px">Today's Incidents</div>
                        <div class="text-muted" style="font-size:12px">Total violations recorded</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon bg-primary text-white rounded-3"
                         style="width:52px;height:52px;font-size:20px;display:flex;align-items:center;justify-content:center">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:28px;line-height:1">{{ $dailySafetyCompliance }}%</div>
                        <div class="fw-semibold" style="font-size:14px;margin-top:2px">Safety Compliance</div>
                        <div class="text-muted" style="font-size:12px">Overall workplace rate</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-icon text-white rounded-3"
                         style="width:52px;height:52px;font-size:20px;display:flex;align-items:center;justify-content:center;background:#22c55e">
                        <i class="fa-solid fa-tower-broadcast"></i>
                    </div>
                    <div>
                        <div class="fw-bold d-flex align-items-center gap-2" style="font-size:22px;line-height:1">
                            ONLINE
                            <span class="rounded-circle bg-success d-inline-block" style="width:8px;height:8px"></span>
                        </div>
                        <div class="fw-semibold" style="font-size:14px;margin-top:2px">AI Monitoring</div>
                        <div class="text-muted" style="font-size:12px">Detection systems active</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="card border-0 p-4">
        <div class="mb-3">
            <h5 class="fw-bold mb-1">Today's Safety Violations</h5>
            <p class="text-muted small mb-0">AI detection activity across all monitoring modules</p>
        </div>
        <canvas id="safetyChart"></canvas>
    </div>

</section>

<script>window.chartData = @json($chartData);</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection