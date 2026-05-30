<?php

namespace App\Livewire;

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

        return view('livewire.detection-search', [
            'vesteLogs' => (clone $baseQuery)
                ->whereHas('ppe', fn($q) => $q->where('ppe_type', 'veste'))
                ->paginate(20, ['*'], 'vest_page'),

            'helmetLogs' => (clone $baseQuery)
                ->whereHas('ppe', fn($q) => $q->where('ppe_type', 'helmet'))
                ->paginate(20, ['*'], 'helmet_page'),
        ]);
    }
}
