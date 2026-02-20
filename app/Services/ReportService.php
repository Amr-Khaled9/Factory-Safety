<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{

    public function getDailySafetyCompliance()
    {
        return $this->calculateSafetyCompliance(Carbon::today(), Carbon::today()->endOfDay());
    }


    public function getWeeklySafetyCompliance()
    {
        return $this->calculateSafetyCompliance(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
    }


    private function calculateSafetyCompliance($start, $end)
    {
        $tables = ['ppe_logs', 'vehicle_logs', 'area_logs'];
        $totalAll = 0;
        $totalPeriod = 0;

        foreach ($tables as $table) {
            $totalAll += DB::table($table)->count();
            $totalPeriod += DB::table($table)
                ->whereBetween('created_at', [$start, $end])
                ->count();
        }

        if ($totalAll == 0) {
            return 0;
        }

        return  round(($totalPeriod / $totalAll) * 100, 2);
    }


    public function getDailyReport()
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        return $this->generateReport($todayStart, $todayEnd);
    }


    public function getWeeklyReport()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        return $this->generateReport($weekStart, $weekEnd);
    }


    private function generateReport($start, $end)
    {
        return [
            'ppe_logs' => DB::table('ppe_logs')->whereBetween('created_at', [$start, $end])->count(),
            'vehicle_logs' => DB::table('vehicle_logs')->whereBetween('created_at', [$start, $end])->count(),
            'area_logs' => DB::table('area_logs')->whereBetween('created_at', [$start, $end])->count(),
            'most_dangerous_areas' => DB::table('area_logs')
                ->select('area_id', DB::raw('COUNT(*) as accidents_count'))
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('area_id')
                ->orderByDesc('accidents_count')
                ->get(),
        ];
    }
}
