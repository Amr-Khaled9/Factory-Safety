<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Http\Controllers\Controller;
use App\Http\Requests\PEELogRequest;
use App\Jobs\SendNotificationJob;
use App\Models\PPE;
use App\Models\PPELog;
use App\Models\User;
use App\Notifications\PEELogNotification;
use App\Services\FcmService;
use App\Services\PPELogServices;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;

class PPELogControler extends Controller
{
    use UploadImageTrait;
    private $pEELogServices;
    private $fcmService;
    public function __construct(PPELogServices $pEELogServices, FcmService $fcmService)
    {
        $this->pEELogServices = $pEELogServices;
        $this->fcmService = $fcmService;
    }

    public function storePpeLogAndNotify(PEELogRequest $request)
    {
        $response = DB::transaction(function () use ($request) {

            $imagePath = $this->uploadLocal($request->image, 'ppe');

            $imageTwoPath = $request->hasFile('image_two')
                ? $this->uploadLocal($request->image_two, 'ppe')
                : null;

            $peeLog = $this->pEELogServices->create($request, $imagePath, $imageTwoPath);

            $violationsList = implode(', ', $request->violations);

            $notificationTitle = 'Worker Detected Without PPE';
            $notificationMessage = "PPE {$violationsList} is not being worn by the worker.";

            SendNotificationJob::dispatch(
                $notificationTitle,
                $notificationMessage,
                new PEELogNotification($notificationTitle, $notificationMessage, $peeLog)
            );

            return response()->json([
                'status'  => 'success',
                'message' => $notificationMessage,
                'data' => [
                    'title'         => $notificationTitle,
                    'number_camera' => $request->number_camera,
                    'person_id'     => $request->person_id,
                    'log'           => $peeLog,
                ],
            ]);
        });

        return $response;
    }

    public function index()
    {
        $logs = PPELog::with(['camera', 'worker'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json([
            'status'  => 'success',
            'message' => "PPE logs fetched successfully",
            'data'    => $logs
        ], 200);
    }


    public function show($id)
    {
        $log = PPELog::with(['camera', 'worker'])
            ->findOrFail($id);
        return response()->json([
            'status'  => 'success',
            'message' => "PEE log fetched successfully",
            'data' => $log

        ], 200);
    }
}
