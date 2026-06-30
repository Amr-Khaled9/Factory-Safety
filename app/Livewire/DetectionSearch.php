<?php

namespace App\Livewire;

use App\Models\PPELog;
use Livewire\Component;
use Livewire\WithPagination;

class DetectionSearch extends Component
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
        $logs = PPELog::query()
            ->when($this->search, function ($q) {
                $q->where('id', $this->search);
            })
            ->when($this->date, function ($q) {
                $q->whereDate('created_at', $this->date);
            })
            ->latest()
            ->paginate(20);

        return view('livewire.detection-search', compact('logs'));
    }
}
