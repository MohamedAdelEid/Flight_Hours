<?php

namespace App\Livewire;

use App\Models\Flight;
use Livewire\Component;
use Livewire\WithPagination;

class FlightTable extends Component
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
        Flight::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }

    public function render()
    {
        return view('livewire.flight-table', [
            'flights' => Flight::with(['aircraft', 'originAirport', 'destinationAirport', 'flightHours'])
                ->search($this->search)
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
