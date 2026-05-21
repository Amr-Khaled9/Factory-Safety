<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }


    public function index()
    {
        $daily = $this->reportService->getDailyReport();
        $weekly = $this->reportService->getWeeklyReport();

        $dailyCompliance = $this->reportService->getDailySafetyCompliance();
        $weeklyCompliance = $this->reportService->getWeeklySafetyCompliance();

        return view('reports.index', [
            'daily' => $daily,
            'weekly' => $weekly,
            'dailyCompliance' => $dailyCompliance,
            'weeklyCompliance' => $weeklyCompliance,
        ]);
    }
}
