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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;
use Cloudinary\Cloudinary;

class VehicleLogController extends Controller
{
    public function handle(VehicleLogRequest $request,Cloudinary $cloudinary)
    {

        $vehicle = Vehicle::where('license_plate', $request->license_plate)
            ->where('authorized', 1)
            ->first();
        $vehicleNotAuthorized = Vehicle::where('license_plate', $request->license_plate)
            ->where('authorized', 0)
            ->first();

        if ($vehicle) {
            return response()->json([
                'status'  => 'success',
                'message' => 'authorized Vehicle Detected',
                'data' => [
                    'detiles_vehicle' => $vehicle,
                    'number_camera' => $request->number_camera,

                ],

            ]);
        }
        if ($vehicleNotAuthorized) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Vehicle [' . $request->license_plate . '] entered and is NOT authorized.',
                'data' => [
                    'detiles_vehicle' => $vehicleNotAuthorized,
                    'number_camera' => $request->number_camera
                ],

            ]);
        }





        if (!$vehicle) {
            $response = DB::transaction(function () use ($request,$cloudinary) {

                // Upload image
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_KEY'),
                    'api_secret' => env('CLOUDINARY_SECRET'),
                ],
            ]);
            $path = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'laravel_uploads']
            );

                // Create vehicle
                $newVehicle = Vehicle::create([
                    'license_plate' => $request->license_plate,
                    'authorized' => false,
                    'vehicle_type' => 'car',
                    'image' => $path['secure_url']
                ]);

                // Create Log
                $vehicleLog = VehicleLog::create([
                    'license_plate' => $newVehicle->license_plate,
                    'image' => $path['secure_url'],
                    'authorized' => $newVehicle->authorized,
                    'vehicle_id' => $newVehicle->id,
                    'camera_id' => Camera::where('number_camera', $request->number_camera)->value('id')
                ]);

                // Get all admins
                $admins = User::role('admin', 'api')->get();

                // Prepare notification message
                $notificationMessage = 'Vehicle [' . $newVehicle->license_plate . '] entered and is NOT authorized.';
                $notificationTitle = 'Unauthorized Vehicle Detected';

                // Send notification to each admin
                foreach ($admins as $admin) {

                    $admin->notify(new VehicleLogNotification(
                        $notificationTitle,
                        $notificationMessage,
                        $vehicleLog
                    ));
                }

                // Return the response after all operations are successful
                return response()->json([
                    'status'  => 'success',
                    'message' => $notificationMessage,
                    'data' => [
                        'title' => $notificationTitle,
                        'detiles_vehicle' => $vehicleLog,
                        'number_camera' => $request->number_camera,
                        'image'=>$path['secure_url']

                    ],
                ]);
            });

            return $response;
        }
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
}
