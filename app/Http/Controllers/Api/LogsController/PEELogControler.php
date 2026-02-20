<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Http\Controllers\Controller;
use App\Http\Requests\PEELogRequest;
use App\Models\PPELog;
use App\Services\PEELogServices;
use Illuminate\Support\Facades\DB;

class PEELogControler extends Controller
{
    private $pEELogServices;
    public function __construct(PEELogServices $pEELogServices)
    {
        $this->pEELogServices = $pEELogServices;
    }

    public function storePpeLogAndNotify(PEELogRequest $request)
    {

        $response = DB::transaction(function () use ($request) {

            $imagePath = $this->pEELogServices->upload($request->image);

            $peeLog = $this->pEELogServices->create($request, $imagePath);
            $ppeType = strtolower($request->type);


            $notificationTitle = 'Worker Detected Without PPE';
            $notificationMessage = "PPE {$ppeType} is not being worn by the worker.";

            $this->pEELogServices->notifyAdmins($peeLog, $notificationTitle, $notificationMessage);

            return response()->json([
                'status'  => 'success',
                'message' => $notificationMessage,
                'data' => [
                    'title' => $notificationTitle,
                    'number_camera' => $request->number_camera,
                    'log' => $peeLog,

                ],
            ]);
        });

        return $response;
    }

    public function index()
    {
        $vesteLogs = PPELog::with(['camera', 'pees', 'worker'])
            ->whereHas('pees', function ($q) {
                $q->where('ppe_type', 'veste');
            })
            ->orderByDesc('created_at')
            ->get();

        $helmetLogs = PPELog::with(['camera', 'pees', 'worker'])
            ->whereHas('pees', function ($q) {
                $q->where('ppe_type', 'helmet');
            })
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => "PPE logs fetched successfully",
            'data' => [
                'veste' => $vesteLogs,
                'helmet' => $helmetLogs,
            ]
        ], 200);
    }


    public function show($id)
    {
        $log = PPELog::with(['camera', 'pees', 'worker'])
            ->findOrFail($id);
        return response()->json([
            'status'  => 'success',
            'message' => "PEE log fetched successfully",
            'data' => $log

        ], 200);
    }
}
