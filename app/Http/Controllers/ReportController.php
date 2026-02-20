<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function getReport()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Safety reports fetched successfully',
            'data' => [
                'daily' => [
                    'report' => $this->reportService->getDailyReport(),
                    'safety_compliance' => $this->reportService->getDailySafetyCompliance(),
                ],
                'weekly' => [
                    'report' => $this->reportService->getWeeklyReport(),
                    'safety_compliance' => $this->reportService->getWeeklySafetyCompliance(),
                ],
            ],
        ], 200);
    }
}
