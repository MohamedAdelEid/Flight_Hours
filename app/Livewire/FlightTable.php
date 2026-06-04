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

    public $flightType = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function filterByType(string $type): void
    {
        $this->flightType = $type;
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Flight::findOrFail($id)->delete();
        $this->dispatch('deleted');
    }

    public function render()
    {
        $query = Flight::with(['aircraft', 'originAirport', 'destinationAirport', 'flightHours'])
            ->search($this->search);

        if ($this->flightType) {
            $query->where('flight_type', $this->flightType);
        }

        return view('livewire.flight-table', [
            'flights' => $query->latest()->paginate($this->perPage),
        ]);
    }
}
