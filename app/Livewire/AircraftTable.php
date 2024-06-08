<?php

namespace App\Livewire;

use App\Models\Aircraft;
use App\Models\Airport;
use Livewire\Component;
use Livewire\WithPagination;

class AircraftTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $status = '';
    public function delete(Aircraft $aircraft){
        $aircraft->delete();
    }
    public function render()
    {
        return view('livewire.aircraft-table',[
            'aircrafts' => Aircraft::search($this->search)->paginate($this->perPage)
        ]);
    }
}
