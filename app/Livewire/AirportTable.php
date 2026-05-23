<?php

namespace App\Livewire;

use App\Models\Airport;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class AirportTable extends Component
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
        try {
            Airport::findOrFail($id)->delete();
            $this->dispatch('deleted');
        } catch (QueryException) {
            $this->dispatch('delete-failed');
        }
    }
    public function render()
    {
        return view('livewire.airport-table', [
            'airports' => Airport::with('user')
                ->search($this->search)
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
