<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpeedViolationRequest;
use App\Models\SpeedViolation;
use App\Models\User;
use App\Services\FcmService;
use App\Services\SpeedViolationService;
use Google\Service\CloudSearch\User as CloudSearchUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SpeedViolationController extends Controller
{
    private $speedViolation;
    private $fcmService;

    public function __construct(SpeedViolationService $speedViolationService, FcmService $fcmService)
    {
        $this->speedViolation = $speedViolationService;
        $this->fcmService = $fcmService;
    }
    public function storeSpeedViolationAndNotify(StoreSpeedViolationRequest $request)
    {
        $response = DB::transaction(function () use ($request) {

            $violation = $this->speedViolation->store($request);

            $notificationTitle = 'Speed Violation';
            $notificationMessage = "Car exceeded speed limit with {$request->carSpeed} km/h";

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
                    'log' => $violation,
                ],
            ]);
        });

        return $response;
    }


    public function index()
    {
        $violations = SpeedViolation::orderByDesc('created_at')->get();

        return response()->json([
            'status'  => 'success',
            'message' => "Speed violations fetched successfully",
            'data' => $violations
        ], 200);
    }


    public function show($id)
    {
        $violation = SpeedViolation::find($id);
        if (!$violation) {
            return response()->json([
                'status'  => 'fail',
                'message' => "Speed violation not found",
                'data' => null
            ], 404);
        }
        return response()->json([
            'status'  => 'success',
            'message' => "Speed violation fetched successfully",
            'data' => $violation
        ], 200);
    }
}
