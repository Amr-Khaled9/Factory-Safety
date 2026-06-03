<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Http\Controllers\Controller;
use App\Http\Requests\PEELogRequest;
use App\Models\PPE;
use App\Models\PPELog;
use App\Models\User;
use App\Notifications\PEELogNotification;
use App\Services\FcmService;
use App\Services\PEELogServices;
use Illuminate\Support\Facades\DB;

class PEELogControler extends Controller
{
    private $pEELogServices;
    private $fcmService;
    public function __construct(PEELogServices $pEELogServices, FcmService $fcmService)
    {
        $this->pEELogServices = $pEELogServices;
        $this->fcmService = $fcmService;
    }

    public function storePpeLogAndNotify(PEELogRequest $request)
    {

        $response = DB::transaction(function () use ($request) {

            $imagePath = $this->pEELogServices->uploadLocal($request->image);

            $peeLog = $this->pEELogServices->create($request, $imagePath);
            $ppeType = strtolower($request->type);


            $notificationTitle = 'Worker Detected Without PPE';
            $notificationMessage = "PPE {$ppeType} is not being worn by the worker.";

            $users = User::whereHas('fcmToken')->with('fcmToken')->get();

            foreach ($users as $user) {

                if ($user->fcmToken && $user->fcmToken->fcm_token) {
                    $this->fcmService->sendNotification(
                        $user->fcmToken->fcm_token,
                        $notificationTitle,
                        $notificationMessage,
                    );
                }

                $user->notify(
                    new PEELogNotification(
                        $notificationTitle,
                        $notificationMessage,
                        $peeLog
                    )
                );
            }

            $users1 = User::all();
            foreach ($users1 as $user1) {
                $user1->notify(
                    new PEELogNotification(
                        $notificationTitle,
                        $notificationMessage,
                        $peeLog
                    )
                );
            }
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
        $ppeTypes = PPE::pluck('ppe_type');

        $logs = [];

        foreach ($ppeTypes as $type) {

            $logs[$type] = PPELog::with(['camera', 'pees', 'worker'])
                ->whereHas('pees', function ($q) use ($type) {
                    $q->where('ppe_type', $type);
                })
                ->orderByDesc('created_at')
                ->paginate(10, ['*'], $type . '_page');
        }

        return response()->json([
            'status'  => 'success',
            'message' => "PPE logs fetched successfully",
            'data'    => $logs
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
