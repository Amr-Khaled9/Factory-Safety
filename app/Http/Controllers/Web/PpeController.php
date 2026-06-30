<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PPELog;

class PpeController extends Controller
{
    public function index()
    {
        $logs = PPELog::with(['camera'])
            ->latest()
            ->limit(100)
            ->get();

        return view('ppe.index', compact('logs'));
    }

    public function show($id)
    {
        $log = PPELog::with(['camera'])
            ->findOrFail($id);

        return view('ppe.show', compact('log'));
    }
}
