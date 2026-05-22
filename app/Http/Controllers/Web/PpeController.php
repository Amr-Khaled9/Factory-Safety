<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PPELog;

class PpeController extends Controller
{
    public function index()
    {
        $vesteLogs = PPELog::with(['camera', 'pees', 'worker'])
            ->whereHas('pees', function ($q) {
                $q->where('ppe_type', 'veste');
            })
            ->latest()
            ->limit(100)
            ->get();

        $helmetLogs = PPELog::with(['camera', 'pees', 'worker'])
            ->whereHas('pees', function ($q) {
                $q->where('ppe_type', 'helmet');
            })
            ->latest()
            ->limit(100)
            ->get();

        return view('ppe.index', compact(
            'vesteLogs',
            'helmetLogs'
        ));
    }

    public function show($id)
    {
        $log = PPELog::with(['camera', 'pees', 'worker'])
            ->findOrFail($id);

        return view('ppe.show', compact('log'));
    }
}
