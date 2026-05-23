<?php

namespace App\Livewire;

use App\Models\Crew;
use Livewire\Component;
use Livewire\WithPagination;

class CrewTable extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 5;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Crew::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }

    public function render()
    {
        return view('livewire.crew-table', [
            'crews' => Crew::with('job')
                ->search($this->search)
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
