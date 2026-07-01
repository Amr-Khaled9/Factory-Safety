<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Models\Camera;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleLog;
use App\Notifications\VehicleLogNotification;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadImageTrait;

class VehicleDetectionService
{
    use UploadImageTrait;
    private $fcmService;
    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }
    public function processAiVehicleDetection(array $data): array
    {
        $vehicle = Vehicle::where('license_plate', $data['license_plate'])->first();

        if ($vehicle && $vehicle->authorized === 1) {
            return $this->authorizedResponse($vehicle, $data['number_camera']);
        }

        if ($vehicle && !$vehicle->authorized === 1) {
            return $this->unauthorizedResponse($vehicle, $data['number_camera']);
        }

        return $this->handleNewUnauthorizedVehicle($data);
    }

    private function handleNewUnauthorizedVehicle(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $imageUrl = $this->uploadLocal($data['image'], 'vehicle');

            $vehicle = Vehicle::firstOrCreate(
                ['license_plate' => $data['license_plate']],
                [
                    'authorized'   => false,
                    'vehicle_type' => 'car',
                    'image'        => $imageUrl,
                ]
            );
            $vehicleLog = VehicleLog::create([
                'license_plate' => $vehicle->license_plate,
                'image'         => $imageUrl,
                'authorized'    => false,
                'vehicle_id'    => $vehicle->id,
                'camera_id'     => Camera::where('number_camera', $data['number_camera'])->value('id'),
                'plate_color'   => $data['plate_color'],
            ]);

            $notificationTitle = 'Unauthorized Vehicle Detected';
            $notificationMessage = "Vehicle [{$vehicleLog->license_plate}] entered and is NOT authorized.";

            SendNotificationJob::dispatch(
                $notificationTitle,
                $notificationMessage,
                new VehicleLogNotification($notificationTitle, $notificationMessage, $vehicleLog)
            );

            return [
                'status'  => 'success',
                'message' => "Vehicle [{$vehicle->license_plate}] entered and is NOT authorized.",
                'data'    => [
                    'vehicle_log'  => $vehicleLog,
                    'number_camera' => $data['number_camera'],
                    'image'        => $imageUrl,
                ],
            ];
        });
    }

    private function authorizedResponse(Vehicle $vehicle, int $cameraNumber): array
    {
        return [
            'status'  => 'success',
            'message' => 'Authorized vehicle detected',
            'data'    => [
                'vehicle'       => $vehicle,
                'number_camera' => $cameraNumber,
            ],
        ];
    }

    private function unauthorizedResponse(Vehicle $vehicle, int $cameraNumber): array
    {
        return [
            'status'  => 'success',
            'message' => "Vehicle [{$vehicle->license_plate}] entered and is NOT authorized.",
            'data'    => [
                'vehicle'       => $vehicle,
                'number_camera' => $cameraNumber,
            ],
        ];
    }
}
