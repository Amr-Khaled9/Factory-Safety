<?php

namespace App\Livewire;

use App\Models\FireLog;
use Livewire\Component;
use Livewire\WithPagination;

class FireLogSearch extends Component
{
    use WithPagination;

    public string $search = '';
    public string $date = '';
    public string $type = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedDate(): void
    {
        $this->resetPage();
    }
    public function updatedType(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = FireLog::query()
            ->when($this->search, fn($q) => $q->where('id', $this->search))
            ->when($this->date,   fn($q) => $q->whereDate('created_at', $this->date))
            ->when($this->type,   fn($q) => $q->where('type', $this->type))
            ->latest()
            ->paginate(12);

        return view('livewire.fire-log-search', compact('logs'));
    }
}
