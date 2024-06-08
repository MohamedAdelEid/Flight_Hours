<?php

namespace App\Livewire;

use App\Models\Airport;
use Livewire\Component;
use Livewire\WithPagination;

class AirportTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public function delete(Airport $airport){
        $airport->delete();
    }
    public function render()
    {
        return view('livewire.airport-table',[
            'airports' => Airport::search($this->search)->paginate($this->perPage)
        ]);
    }
}
