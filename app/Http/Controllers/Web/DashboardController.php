<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $today = now()->toDateString();

        $todayAccidentCount = $this->dashboardService->allTodayAccidentCount();

        $dailySafetyCompliance = $this->dashboardService->getDailySafetyCompliance();


        $chartData = [
            'PPE' => \App\Models\PPELog::whereDate('created_at', $today)->count(),
            'Vehicles' => \App\Models\VehicleLog::whereDate('created_at', $today)->count(),
            'Fire' => \App\Models\FireLog::whereDate('created_at', $today)->count(),
        ];

        return view('dashboard.index', compact('todayAccidentCount', 'dailySafetyCompliance', 'chartData'));
    }
}
