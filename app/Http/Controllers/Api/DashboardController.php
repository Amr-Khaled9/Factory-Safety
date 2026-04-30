<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard data fetched successfully',
            'data'    => [
                'today_accident_count' => $this->dashboardService->allTodayAccidentCount(),
                'safety_compliance' => $this->dashboardService->getDailySafetyCompliance(),
                'real_time_alerts' => $this->dashboardService->getRealTimeAlerts(),
            ]
        ], 200);
    }
}
