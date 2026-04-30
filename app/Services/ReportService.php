<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDailySafetyCompliance()
    {
        return $this->calculateSafetyCompliance(
            Carbon::today(),
            Carbon::today()->endOfDay()
        );
    }

    public function getWeeklySafetyCompliance()
    {
        return $this->calculateSafetyCompliance(
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        );
    }

    private function calculateSafetyCompliance($start, $end)
    {
        $tables = [
            'ppe_logs',
            'vehicle_logs',
            'speed_violations',
            'fire_logs'
        ];

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

         return 100 - round(($totalPeriod / $totalAll) * 100, 2) ;
    }

    public function getDailyReport()
    {
        return $this->generateReport(
            Carbon::today(),
            Carbon::today()->endOfDay()
        );
    }

    public function getWeeklyReport()
    {
        return $this->generateReport(
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        );
    }

    private function generateReport($start, $end)
    {
        return [
            'ppe_logs' => DB::table('ppe_logs')
                ->whereBetween('created_at', [$start, $end])
                ->count(),

            'vehicle_logs' => DB::table('vehicle_logs')
                ->whereBetween('created_at', [$start, $end])
                ->count(),

            'speed_violations' => DB::table('speed_violations')
                ->whereBetween('created_at', [$start, $end])
                ->count(),

            'fire_logs' => DB::table('fire_logs')
                ->whereBetween('created_at', [$start, $end])
                ->count(),
        ];
    }
}
