<?php

namespace App\Http\Controllers\Api\LogsController;

use App\Events\PEEDetected;
use App\Http\Controllers\Controller;
use App\Http\Requests\PEELogRequest;
use App\Models\Camera;
use App\Models\Notification;
use App\Models\PPELog;
use App\Models\User;
use App\Notifications\PEELogNotification;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PEELogControler extends Controller
{
    public function handle(PEELogRequest $request, Cloudinary $cloudinary)
    {

        $response = DB::transaction(function () use ($request,$cloudinary) {
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


            // $request->image->storeAs('image/pees', $imageName, 'public');
            $peeLog = PPELog::create([
                'image' => $path['secure_url'],
                'ppe_id' => 1,
                'camera_id' => Camera::where('number_camera', $request->number_camera)->value('id'),
                'worker_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $admins = User::role('admin', 'api')->get();

            $notificationTitle = 'Worker Detected Without PPE';
            $notificationMessage = 'PPE [Veste and Helmet] is not being worn by the worker.';

            foreach ($admins as $admin) {
                $admin->notify(new PEELogNotification(
                    $notificationTitle,
                    $notificationMessage,
                    $peeLog
                ));
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
        $logs = PPELog::with(['camera', 'pees', 'worker'])
            ->orderByDesc('created_at')
            ->get();
        return response()->json([
            'status'  => 'success',
            'message' => "PEE logs fetched successfully",
            'data' => $logs

        ], 200);
    }
}
