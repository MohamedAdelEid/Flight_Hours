<?php

namespace App\Livewire;

use App\Models\Aircraft;
use App\Models\Flight;
use Livewire\Component;
use Livewire\WithPagination;

class FlightTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $status = '';
    public function delete(Flight $flight)
    {
        $deleteFlight = $flight->delete();
        if ($deleteFlight) {
            $this->dispatch('deleted');
        }
    }
    public function render()
    {
        return view('livewire.flight-table', [
            'flights' => Flight::search($this->search)->paginate($this->perPage)
        ]);
    }
}
