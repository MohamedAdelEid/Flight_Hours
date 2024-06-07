<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class JobTable extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.job-table', [
            'jobs' => Job::paginate(5)
        ]);
    }
}
