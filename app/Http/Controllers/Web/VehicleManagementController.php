<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateVehiclRequest;
use App\Http\Requests\Admin\UpdateVehiclRequest;
use App\Models\Vehicle;
use App\Services\VehicleDetectionService;

class VehicleManagementController extends Controller
{
    private $vehicleDetectionService;

    public function __construct(
        VehicleDetectionService $vehicleDetectionService
    ) {
        $this->vehicleDetectionService = $vehicleDetectionService;
    }

    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(CreateVehiclRequest $request)
    {
        $data = $request->validated();

        $imageUrl = $this->vehicleDetectionService
            ->uploadImage($request->file('image'));

        Vehicle::create([
            'authorized'    => $data['authorized'],
            'license_plate' => $data['license_plate'],
            'vehicle_type'  => $data['vehicle_type'],
            'image'         => $imageUrl,
        ]);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully');
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(UpdateVehiclRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {

            $imageUrl = $this->vehicleDetectionService
                ->uploadImage($request->file('image'));

            $data['image'] = $imageUrl;
        }

        $vehicle->update($data);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully');
    }

    public function authorized()
    {
        $vehicles = Vehicle::where('authorized', 1)
            ->latest()
            ->paginate(10);

        return view(
            'vehicles.authorized',
            compact('vehicles')
        );
    }

    public function unauthorized()
    {
        $vehicles = Vehicle::where('authorized', 0)
            ->latest()
            ->paginate(10);

        return view(
            'vehicles.unauthorized',
            compact('vehicles')
        );
    }
}
