<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateVehiclRequest;
use App\Http\Requests\Admin\UpdateVehiclRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiclManagementController extends Controller
{
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
        $vehicle = Vehicle::create($request->all());
        return response()->json([
            'status'  => 'success',
            'message' => "Vehicle Created successfully",
            'data' => $vehicle

        ], 200);
    }

    public function update(UpdateVehiclRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
         $vehicle->update($request->validated());

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
