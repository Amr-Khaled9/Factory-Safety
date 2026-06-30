<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FireLog;

class FireController extends Controller
{
    public function index()
    {
        $logs = FireLog::with(['camera'])
            ->latest()
            ->limit(100)
            ->get();

        return view('fire.index', compact('logs'));
    }

    public function show($id)
    {
        $log = FireLog::with(['camera'])
            ->findOrFail($id);

        return view('fire.show', compact('log'));
    }
}


