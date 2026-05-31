<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFireLogRequest;
use App\Models\FireLog;
use App\Models\User;
use App\Services\FcmService;
use App\Services\FireLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FireLogController extends Controller
{
    private $fireLog;
    private $fcmService;

    public function __construct(FireLogService $fireLogService, FcmService $fcmService)
    {
        $this->fireLog = $fireLogService;
        $this->fcmService = $fcmService;
    }

    public function storeFireAndNotify(StoreFireLogRequest $request)
    {
        $response = DB::transaction(function () use ($request) {

            $log = $this->fireLog->store($request);

            $notificationTitle = 'Fire Alert 🚨';
            $notificationMessage = "Detected {$request->type} with confidence {$request->confidence}";

            $users = User::whereHas('fcmToken')
                ->with('fcmToken')
                ->get();

            foreach ($users as $user) {
                if ($user->fcmToken && $user->fcmToken->fcm_token) {
                    $this->fcmService->sendNotification(
                        $user->fcmToken->fcm_token,
                        $notificationTitle,
                        $notificationMessage
                    );
                }
            }

            return response()->json([
                'status'  => 'success',
                'message' => $notificationMessage,
                'data' => [
                    'title' => $notificationTitle,
                    'number_camera' => $request->number_camera,
                    'log' => $log,
                ],
            ]);
        });

        return $response;
    }

    public function index()
    {
        $logs = FireLog::orderByDesc('created_at')->paginate(15);

        return response()->json([
            'status'  => 'success',
            'message' => "Fire logs fetched successfully",
            'data' => $logs
        ]);
    }

    public function show($id)
    {
        $log = FireLog::find($id);

        if (!$log) {
            return response()->json([
                'status' => 'fail',
                'message' => "Fire log not found",
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Fire log fetched successfully",
            'data' => $log
        ]);
    }
}
