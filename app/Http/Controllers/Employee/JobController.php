<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        return view('employee.job.index', [
            'jobs' => Job::with('user')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create()
    {
        return view('employee.job.add', ['job_types' => JobType::all()]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatedData($request);

        Job::create([
            'job_name' => $validatedData['job_name'],
            'type_id' => $validatedData['type_id'],
            'status' => $validatedData['status'],
            'user_id' => Auth::id(),
            'hourly_calculation' => $validatedData['hourly_calculation'] ?? 0,
        ]);

        return redirect()->route('job.index')->with('successCreate', 'تم إضافة وظيفة بنجاح');
    }

    public function show(Job $job)
    {
        return view('employee.job.show', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        return view('employee.job.edit', [
            'job' => $job,
            'job_types' => JobType::all(),
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $validatedData = $this->validatedData($request);

        $job->update([
            'job_name' => $validatedData['job_name'],
            'type_id' => $validatedData['type_id'],
            'status' => $validatedData['status'],
            'hourly_calculation' => $validatedData['hourly_calculation'] ?? 0,
        ]);

        return redirect()->route('job.index')->with('successUpdate', 'تم تعديل الوظيفة بنجاح');
    }

    public function destroy(Job $job)
    {
        try {
            $job->delete();
        } catch (QueryException) {
            return redirect()->route('job.index')->with('error', 'لا يمكن حذف الوظيفة لأنها مرتبطة ببيانات أخرى');
        }

        return redirect()->route('job.index')->with('success', 'تم حذف الوظيفة بنجاح');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'job_name' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'exists:job_types,id'],
            'status' => ['required', 'in:active,inactive'],
            'hourly_calculation' => ['nullable', 'boolean'],
        ]);
    }
}