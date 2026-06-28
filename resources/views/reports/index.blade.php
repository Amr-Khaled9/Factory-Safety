@extends('layouts.app')

@section('title', 'Safety Reports')
@section('page-title', 'Safety Analytics')
@section('page-subtitle', 'Daily & weekly monitoring data')

@section('content')

<section class="p-4">

    <!-- Header + Toggle -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-size:26px">Safety Analytics Report</h1>
            <p class="text-muted small mb-0">AI-powered violation tracking and compliance metrics</p>
        </div>
        <div class="d-flex gap-2">
            <button id="dailyBtn" class="btn btn-primary btn-sm fw-semibold px-4" onclick="showDaily()">
                <i class="fa-regular fa-calendar me-1"></i>Daily
            </button>
            <button id="weeklyBtn" class="btn btn-outline-secondary btn-sm fw-semibold px-4" onclick="showWeekly()">
                <i class="fa-solid fa-calendar-week me-1"></i>Weekly
            </button>
        </div>
    </div>

    <!-- Daily Section -->
    <div id="daily">

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 p-4" style="border-left:4px solid var(--brand) !important">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="fa-solid fa-hard-hat text-primary fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:30px;line-height:1">{{ $daily['ppe_logs'] }}</div>
                            <div class="text-muted small">PPE Violations Today</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 p-4" style="border-left:4px solid var(--danger) !important">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="fa-solid fa-car text-danger fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:30px;line-height:1">{{ $daily['vehicle_logs'] }}</div>
                            <div class="text-muted small">Vehicle Logs Today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 p-4 text-center">
            <h5 class="fw-bold mb-1">Daily Safety Compliance</h5>
            <p class="text-muted small mb-4">Based on AI detections vs total monitored events</p>
            <div class="progress rounded-3 mb-3" style="height:16px">
                <div class="progress-bar"
                     role="progressbar"
                     style="width:{{ $dailyCompliance }}%;background:linear-gradient(90deg,#2563eb,#06b6d4)"
                     aria-valuenow="{{ $dailyCompliance }}"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="fw-bold" style="font-size:36px;color:var(--text-primary)">{{ $dailyCompliance }}%</div>
        </div>

    </div>

    <!-- Weekly Section -->
    <div id="weekly" style="display:none">

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 p-4" style="border-left:4px solid var(--brand) !important">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="fa-solid fa-hard-hat text-primary fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:30px;line-height:1">{{ $weekly['ppe_logs'] }}</div>
                            <div class="text-muted small">PPE Violations This Week</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 p-4" style="border-left:4px solid var(--danger) !important">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="fa-solid fa-car text-danger fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:30px;line-height:1">{{ $weekly['vehicle_logs'] }}</div>
                            <div class="text-muted small">Vehicle Logs This Week</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 p-4 text-center">
            <h5 class="fw-bold mb-1">Weekly Safety Compliance</h5>
            <p class="text-muted small mb-4">7-day rolling compliance rate</p>
            <div class="progress rounded-3 mb-3" style="height:16px">
                <div class="progress-bar"
                     role="progressbar"
                     style="width:{{ $weeklyCompliance }}%;background:linear-gradient(90deg,#2563eb,#06b6d4)"
                     aria-valuenow="{{ $weeklyCompliance }}"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="fw-bold" style="font-size:36px;color:var(--text-primary)">{{ $weeklyCompliance }}%</div>
        </div>

    </div>

    <!-- Risk Badge -->
    <div class="card border-0 p-4 mt-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <h5 class="fw-bold mb-0">Risk Assessment</h5>
            @if($dailyCompliance > 90)
            <span class="badge fs-6 fw-bold px-3 py-2" style="background:var(--success-bg);color:var(--success)">
                <i class="fa-solid fa-circle-check me-1"></i>LOW RISK
            </span>
            @elseif($dailyCompliance > 70)
            <span class="badge fs-6 fw-bold px-3 py-2" style="background:var(--warning-bg);color:var(--warning)">
                <i class="fa-solid fa-triangle-exclamation me-1"></i>MEDIUM RISK
            </span>
            @else
            <span class="badge fs-6 fw-bold px-3 py-2" style="background:var(--danger-bg);color:var(--danger)">
                <i class="fa-solid fa-circle-exclamation me-1"></i>HIGH RISK
            </span>
            @endif
        </div>
        <div class="row text-center">
            <div class="col-6 border-end">
                <div class="text-muted small mb-1">PPE Violations</div>
                <div class="fw-bold fs-5">{{ round(($daily['ppe_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%</div>
            </div>
            <div class="col-6">
                <div class="text-muted small mb-1">Vehicle Logs</div>
                <div class="fw-bold fs-5">{{ round(($daily['vehicle_logs'] / max(($daily['ppe_logs'] + $daily['vehicle_logs']),1)) * 100, 1) }}%</div>
            </div>
        </div>
    </div>

</section>

<script>
function showDaily() {
    document.getElementById('daily').style.display = '';
    document.getElementById('weekly').style.display = 'none';
    document.getElementById('dailyBtn').className = 'btn btn-primary btn-sm fw-semibold px-4';
    document.getElementById('weeklyBtn').className = 'btn btn-outline-secondary btn-sm fw-semibold px-4';
}
function showWeekly() {
    document.getElementById('daily').style.display = 'none';
    document.getElementById('weekly').style.display = '';
    document.getElementById('dailyBtn').className = 'btn btn-outline-secondary btn-sm fw-semibold px-4';
    document.getElementById('weeklyBtn').className = 'btn btn-primary btn-sm fw-semibold px-4';
}
</script>

@endsection