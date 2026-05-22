<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VehicleLog;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function index()
    {
        $logs = VehicleLog::latest()->limit(100)->get();

        return view('gate.index', compact('logs'));
    }

    public function show($id)
    {
        $log = VehicleLog::findOrFail($id);

        return view('gate.show', compact('log'));
    }
}
