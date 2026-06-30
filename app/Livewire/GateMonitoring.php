<?php

namespace App\Livewire;

use App\Models\VehicleLog;
use Livewire\Component;
use Livewire\WithPagination;

class GateMonitoring extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = VehicleLog::query()
            ->when($this->search, function ($query) {
                $query->where('license_plate', 'like', '%' . $this->search . '%');
            })
            ->when($this->date, function ($query) {
                $query->whereDate('created_at', $this->date);
            })
            ->latest()
            ->paginate(20);

        return view('livewire.gate-monitoring', ['logs' => $logs]);
    }
}
