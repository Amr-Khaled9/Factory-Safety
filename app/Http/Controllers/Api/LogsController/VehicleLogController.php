<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Events\UnauthorizedVehicleDetected;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleLogRequest;
use App\Models\Camera;
use App\Models\Notification;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleLog;
use App\Notifications\VehicleLogNotification;
use App\Services\VehicleDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;
use Cloudinary\Cloudinary;

class VehicleLogController extends Controller
{
    private $vehicleDetectionService;
    public function __construct(VehicleDetectionService $vehicleDetectionService)
    {
        $this->vehicleDetectionService = $vehicleDetectionService;
    }
    public function storeVehicleLogAndNotify(VehicleLogRequest $request, Cloudinary $cloudinary)
    {
        $result = $this->vehicleDetectionService->processAiVehicleDetection([
            'license_plate' => $request->license_plate,
            'number_camera' => $request->number_camera,
            'image'         => $request->image,
        ]);

        return response()->json($result, 200);
    }


    public function index()
    {
        $logs = VehicleLog::with(['camera', 'vehicle'])->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => "Vehicle logs fetched successfully",
            'data' => $logs

        ], 200);
    }

    public function show($id)
    {
        $log = VehicleLog::with(['camera', 'vehicle'])
            ->findOrFail($id);
            
        return response()->json([
            'status'  => 'success',
            'message' => "Vehicle Log fetched successfully",
            'data' => $log

        ], 200);
    }
}
