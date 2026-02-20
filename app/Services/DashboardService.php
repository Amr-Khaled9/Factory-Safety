<?php

namespace App\Services;

use App\Models\AreaLog;
use App\Models\PPELog;
use App\Models\VehicleLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function allTodayAccidentCount()
    {
        $ppeLog = PPELog::count();
        $vehicleLog = VehicleLog::count();
        $areaLog = AreaLog::count();

        $accidentCount = $ppeLog + $vehicleLog + $areaLog;
        return $accidentCount;
    }

    public function getAreaWithMostViolations()
    {
        $area = AreaLog::select('area_id', DB::raw('COUNT(*) as total'))
            ->groupBy('area_id')
            ->orderByDesc('total')
            ->with('area:id,name')
            ->first();

        if (!$area || !$area->area) {
            return [
                'title' => 'Area with Most Violations',
                'area'  => null,
                'total' => 0,
            ];
        }

        return [
            'title' => 'Area with Most Violations',
            'area'  => $area->area->name,
            'total' => $area->total,
        ];
    }

    public function getRealTimeAlerts()
    {
        $ppeLog = PPELog::with(['worker', 'pees', 'worker'])
            ->latest()
            ->first();

        $vehicleLog = VehicleLog::with(['vehicle', 'camera'])
            ->latest()
            ->first();

        $areaLog = AreaLog::with(['area', 'camera', 'worker'])
            ->latest()
            ->first();

        return [/*  */
            'title'        => 'Real Time Alerts',
            'ppe_log'      => $ppeLog,
            'vehicle_log'  => $vehicleLog,
            'area_log'     => $areaLog,
        ];
    }



    public function getDailySafetyCompliance()
    {
        $today = Carbon::today();

        $tables = ['ppe_logs', 'vehicle_logs', 'area_logs'];

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

        return round(($totalToday / $totalAll) * 100, 2);
    }
}
