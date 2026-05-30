<?php

namespace App\Livewire;

use App\Models\VehicleLog;
use Livewire\Component;
use Livewire\WithPagination;

class GateMonitoring extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = VehicleLog::query()
            ->when($this->search, function ($query) {
                $query->where('license_plate', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(20);
        return view('livewire.gate-monitoring', ['logs' => $logs]);
    }
}
