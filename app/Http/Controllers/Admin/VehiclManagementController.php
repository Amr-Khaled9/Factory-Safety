<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateVehiclRequest;
use App\Http\Requests\Admin\UpdateVehiclRequest;
use App\Models\Vehicle;
use App\Services\VehicleDetectionService;
use Illuminate\Http\Request;

class VehiclManagementController extends Controller
{
    private $vehicleDetectionService;
    public function __construct(VehicleDetectionService $vehicleDetectionService)
    {
        $this->vehicleDetectionService = $vehicleDetectionService;
    }
    public function index()
    {
        $vehicles = Vehicle::paginate(10);
        return response()->json([
            'status'  => 'success',
            'message' => "Vehicle fetched successfully",
            'data' => $vehicles

        ], 200);
    }

    public function create(CreateVehiclRequest $request)
    {
        $data = $request->validated();

        $imageUrl = $this->vehicleDetectionService
            ->uploadImage($request->file('image'));

        $vehicle = Vehicle::create([
            'authorized'    => $data['authorized'],
            'license_plate' => $data['license_plate'],
            'vehicle_type'  => $data['vehicle_type'],
            'image'         => $imageUrl,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehicle Created successfully',
            'data'    => $vehicle
        ], 201);
    }

    public function update(UpdateVehiclRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageUrl = $this->vehicleDetectionService->uploadImage($request->file('image'));
            $data['image'] = $imageUrl;
        }

        $vehicle->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehicle updated successfully',
            'data'    => $vehicle
        ], 200);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehicle deleted successfully'
        ], 200);
    }


    public function authorizedVehicles()
    {
        $vehicles = Vehicle::where('authorized', 1)->paginate(10);

        return response()->json([
            'status'  => 'success',
            'message' => 'Authorized vehicles fetched successfully',
            'data'    => $vehicles
        ], 200);
    }



    public function unauthorizedVehicles()
    {
        $vehicles = Vehicle::where('authorized', 0)->paginate(10);

        return response()->json([
            'status'  => 'success',
            'message' => 'Unauthorized vehicles fetched successfully',
            'data'    => $vehicles
        ], 200);
    }
}
