<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Models\JobType;
use Livewire\WithPagination;

class JobTable extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public $job_type = '';

    public function render()
    {
        return view(
            'livewire.job-table',
            [
                'jobs' => Job::search($this->search)
                    ->when($this->job_type !== '', function ($query) {
                        $query->where('type_id', $this->job_type);
                    })
                    ->paginate($this->perPage),
                'jobTypes' => JobType::all()
            ]
        );

    }

    public function deleteConfirm($id)
    {
        $job = Job::find($id);
        $this->dispatch('swalConfirm',[
            'title' => 'هل انت متاكد ؟',
            'html' => 'انت تريد حذف <strong>'.$job->job_name.'</strong>',
            'id' => $job->id,
        ]);
    }

    public function delete(Job $job)
    {
        $deleteJob = $job->delete();
        if($deleteJob){
            $this->dispatch('deleted');
        }
    }
}
