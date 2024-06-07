<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class JobTable extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public function render()
    {
        return view('livewire.job-table',
            [
            'jobs' => Job::search($this->search)->paginate($this->perPage)
            ]);

    }
}
