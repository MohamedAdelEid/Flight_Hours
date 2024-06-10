<?php

namespace App\Livewire;

use App\Models\Crew;
use App\Models\Job;
use App\Models\JobType;
use Livewire\Component;
use Livewire\WithPagination;

class CrewTable extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;

    public function delete(Crew $crew){
        $crew->delete();
    }
    public function render()
    {
        return view('livewire.crew-table',[
            'crews' => Crew::search($this->search)->paginate($this->perPage)
        ]);
    }
}
