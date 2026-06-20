<?php

namespace App\Livewire;

use App\Models\Crew;
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
        } elseif ($source === 'combined') {
            $flight = Flight::findOrFail($id);
            if ($flight->round_trip_id) {
                Flight::where('round_trip_id', $flight->round_trip_id)->delete();
            } else {
                $flight->delete();
            }
        } else {
            Flight::findOrFail($id)->delete();
        }
        $this->dispatch('deleted');
    }

    public function render()
    {
        $showNormal = !$this->flightType || $this->flightType === 'normal_flight';
        $showOther = !$this->flightType || in_array($this->flightType, ['simulated_flight', 'unloaded_flight', 'airplane_test']);

        $combinedFlights = collect();
        if ($showNormal) {
            $allNormalFlights = Flight::with([
                'aircraft', 'originAirport', 'destinationAirport', 'flightHours',
                'crewNormalFlights.crew.job', 'crewNormalFlights.job'
            ])
            ->where('flight_type', 'normal_flight')
            ->when($this->search, fn($q) => $q->search($this->search))
            ->latest()
            ->get();

            $grouped = $allNormalFlights->groupBy(fn($f) => $f->round_trip_id ?? 'single_' . $f->id);

            $combinedFlights = $grouped->map(function ($group) {
                if ($group->count() === 1) {
                    $f = $group->first();
                    $f->flight_source = 'flights';
                    $f->_isCombined = false;
                    return $f;
                }

                $sorted = $group->sortBy('created_at')->values();
                $dep = $sorted[0];
                $ret = $sorted[1] ?? $sorted[0];

                $f = (object) [
                    'id' => $dep->id,
                    'flight_source' => 'combined',
                    '_isCombined' => true,
                    '_departure' => $dep,
                    '_return' => $ret,
                    'aircraft' => $dep->aircraft,
                    'aircraft_name' => $dep->aircraft?->aircraft_name,
                    'flight_number' => $dep->flight_number,
                    'return_flight_number' => $ret->flight_number,
                    'flight_date' => $dep->flight_date,
                    'return_flight_date' => $ret->flight_date,
                    'origin_airport' => $dep->originAirport,
                    'destination_airport' => $dep->destinationAirport,
                    'return_origin_airport' => $ret->originAirport,
                    'return_destination_airport' => $ret->destinationAirport,
                    'departure_time' => $dep->departure_time,
                    'arrival_time' => $dep->arrival_time,
                    'return_departure_time' => $ret->departure_time,
                    'return_arrival_time' => $ret->arrival_time,
                    'aircraft_number' => $dep->aircraft_number,
                    'status' => $this->mergeStatus($dep->status, $ret->status),
                    '_depStatus' => $dep->status,
                    '_retStatus' => $ret->status,
                    'created_at' => $dep->created_at,
                    'crewNormalFlights' => $dep->crewNormalFlights,
                    'flight_type' => 'normal_flight',
                    'flightHours' => $dep->flightHours,
                    'returnFlightHours' => $ret->flightHours,
                    '_depId' => $dep->id,
                    '_retId' => $ret->id,
                    'reviewed_by' => $dep->reviewed_by,
                    'reviewed_at' => $dep->reviewed_at,
                    'rejection_reason' => $dep->rejection_reason,
                ];
                return $f;
            })->values();
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
                $of->_isCombined = false;
                return $of;
            });
        }

        $combined = $combinedFlights->concat($otherFlights)->sortByDesc('created_at');
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

    private function mergeStatus($status1, $status2): string
    {
        if ($status1 === 'pending_review' || $status2 === 'pending_review') {
            return 'pending_review';
        }
        if ($status1 === 'rejected' || $status2 === 'rejected') {
            return 'rejected';
        }
        if ($status1 === 'completed' && $status2 === 'completed') {
            return 'completed';
        }
        return $status1 ?? $status2;
    }
}
