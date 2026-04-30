<?php

namespace App\Services;

use App\Models\AreaLog;
use App\Models\FireLog;
use App\Models\PPELog;
use App\Models\SpeedViolation;
use App\Models\VehicleLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function allTodayAccidentCount()
    {
        $today = now()->toDateString();

        $ppeLog = PPELog::whereDate('created_at', $today)->count();
        $vehicleLog = VehicleLog::whereDate('created_at', $today)->count();
        $speedLog = SpeedViolation::whereDate('created_at', $today)->count();
        $fireLog = FireLog::whereDate('created_at', $today)->count();

        return $ppeLog + $vehicleLog + $speedLog + $fireLog;
    }

    public function getRealTimeAlerts()
    {
        $ppeLogs = PPELog::with(['worker', 'pees'])
            ->latest()
            ->take(2)
            ->get();

        $vehicleLogs = VehicleLog::with(['vehicle', 'camera'])
            ->latest()
            ->take(2)
            ->get();

        $speedLogs = SpeedViolation::latest()
            ->take(2)
            ->get();

        $fireLogs = FireLog::latest()
            ->take(2)
            ->get();

        return [
            'title'         => 'Real Time Alerts',
            'ppe_log'       => $ppeLogs,
            'vehicle_log'   => $vehicleLogs,
            'speed_log'     => $speedLogs,
            'fire_log'      => $fireLogs,
        ];
    }

    public function getDailySafetyCompliance()
    {
        $today = Carbon::today();

        $tables = [
            'ppe_logs',
            'vehicle_logs',
            'speed_violations',
            'fire_logs'
        ];

        $totalAll = 0;
        $totalToday = 0;

        foreach ($tables as $table) {

            $totalAll += DB::table($table)->count();

            $totalToday += DB::table($table)
                ->whereDate('created_at', $today)
                ->count();
        }

        if ($totalAll == 0) {
            return 0;
        }

        return 100 - round(($totalToday / $totalAll) * 100, 2);
    }
}
