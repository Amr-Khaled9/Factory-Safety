<?php

namespace App\Livewire;

use App\Models\PPE;
use Livewire\Component;
use App\Models\PPELog;
use Livewire\WithPagination;

class DetectionSearch extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $baseQuery = PPELog::query()
            ->when($this->search, function ($q) {
                $q->where('id', $this->search);
            })
            ->latest();

        $ppeTypes = PPE::pluck('ppe_type');

        $logs = [];

        foreach ($ppeTypes as $type) {
            $logs[$type] = (clone $baseQuery)
                ->whereHas('ppe', fn($q) => $q->where('ppe_type', $type))
                ->paginate(20, ['*'], "{$type}_page");
        }

        return view('livewire.detection-search', compact(
            'logs',
            'ppeTypes'
        ));
    }
}
