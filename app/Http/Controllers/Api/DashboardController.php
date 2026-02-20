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
                'Today Accident Count' => $this->dashboardService->allTodayAccidentCount(),
                'getSafetyCompliance' => $this->dashboardService->getDailySafetyCompliance(),
                'Area With Most Violations' => $this->dashboardService->getAreaWithMostViolations(),
                'Real Time Alerts' => $this->dashboardService->getRealTimeAlerts(),
            ]
        ], 200);
    }
}
