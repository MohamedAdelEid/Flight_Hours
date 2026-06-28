<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\JobType;
use Livewire\Component;
use Livewire\WithPagination;

class JobTable extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 5;

    public $job_type = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedJobType(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        try {
            Job::findOrFail($id)->delete();
            $this->dispatch('deleted');
        } catch (QueryException) {
            $this->dispatch('delete-failed');
        }
    }

    public function render()
    {
        return view('livewire.job-table', [
            'jobs' => Job::with(['user', 'job_type'])
                ->search($this->search)
                ->when($this->job_type !== '', fn ($query) => $query->where('type_id', $this->job_type))
                ->latest()
                ->paginate($this->perPage),
            'jobTypes' => JobType::all(),
        ]);
    }
}
