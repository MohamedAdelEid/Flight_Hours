<?php

namespace App\Livewire;

use App\Models\Flight;
use App\Models\OtherFlights;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class FlightTable extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 5;

    public $flightType = '';

    protected $paginationTheme = 'tailwind';

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

    public function delete(int $id, string $source = 'flights'): void
    {
        if ($source === 'other_flights') {
            OtherFlights::findOrFail($id)->delete();
        } else {
            Flight::findOrFail($id)->delete();
        }
        $this->dispatch('deleted');
    }

    public function render()
    {
        $showNormal = !$this->flightType || $this->flightType === 'normal_flight';
        $showOther = !$this->flightType || in_array($this->flightType, ['simulated_flight', 'unloaded_flight', 'airplane_test']);

        $flights = collect();
        if ($showNormal) {
            $query = Flight::with(['aircraft', 'originAirport', 'destinationAirport', 'flightHours', 'crewNormalFlights.crew.job', 'crewNormalFlights.job'])
                ->search($this->search);
            if ($this->flightType) {
                $query->where('flight_type', $this->flightType);
            }
            $flights = $query->latest()->get()->map(function ($f) {
                $f->flight_source = 'flights';
                return $f;
            });
        }

        $otherFlights = collect();
        if ($showOther) {
            $query = OtherFlights::with(['aircraft', 'airport', 'crewFlights.crew.job', 'crewFlights.job']);
            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('flight_number', 'like', "%{$this->search}%")
                      ->orWhere('flight_date', 'like', "%{$this->search}%");
                });
            }
            if ($this->flightType) {
                $query->where('flight_type', $this->flightType);
            }
            $otherFlights = $query->latest()->get()->map(function ($of) {
                $of->flight_source = 'other_flights';
                return $of;
            });
        }

        $combined = $flights->concat($otherFlights)->sortByDesc('created_at');
        $total = $combined->count();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = $combined->forPage($page, $this->perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $this->perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('livewire.flight-table', [
            'flights' => $paginator,
        ]);
    }
}
