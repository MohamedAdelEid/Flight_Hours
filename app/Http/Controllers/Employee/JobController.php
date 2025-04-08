<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        return view('employee.job.index', [
            'jobs' => Job::with('user')->orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        $job_types = JobType::all();
        return view('employee.job.add', ['job_types' => $job_types]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'job_name' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'exists:job_types,id'],
            'status' => ['required', 'in:active,inactive'],
            'hourly_calculation' => ['nullable', 'boolean'],
        ], [
            'job_name.required' => 'حقل اسم الوظيفة مطلوب.',
            'job_name.string' => 'يجب أن يكون اسم الوظيفة نصًا.',
            'job_name.max' => 'قد لا يكون اسم الوظيفة أكبر من 255 حرفًا.',
            'type_id.required' => 'حقل نوع الوظيفة مطلوب.',
            'type_id.exists' => 'النوع المحدد للوظيفة غير موجود.',
            'status.required' => 'حقل حالة الوظيفة مطلوب',
            'status.in' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة".',
            'hourly_calculation.boolean' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة".',
            'hourly_calculation' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة".',
        ]);

        Job::create([
            'job_name' => $request->job_name,
            'type_id' => $request->type_id,
            'status' => $request->status,
            'user_id' => Auth::guard('web')->id(),
            'hourly_calculation' => $request->hourly_calculation ?? 0,
        ]);

        return redirect()->route('job.index')->with('successCreate', 'تم إضافة وظيفة بنجاح');
    }

    public function show(Job $job)
    {
        return view('job.show', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        return view('employee.job.edit', [
            'job' => $job,
            'job_types' => JobType::all()
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $validatedData = $request->validate([
            'job_name' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'exists:job_types,id'],
            'status' => ['required', 'in:active,inactive'],
            'hourly_calculation' => ['nullable', 'boolean'],
        ], [
            'job_name.required' => 'The job name field is required.',
            'job_name.string' => 'The job name must be a string.',
            'job_name.max' => 'The job name may not be greater than 255 characters.',
            'status.required' => 'The job status field is required.',
            'status.in' => 'Invalid job status.',
            'hourly_calculation.boolean' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة".',
            'hourly_calculation' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة".',
        ]);

        $job->update([
            'job_name' => $validatedData['job_name'],
            'type_id' => $validatedData['type_id'],
            'status' => $validatedData['status'],
            'hourly_calculation' => $validatedData['hourly_calculation'] ?? 0,
        ]);

        return redirect()
            ->route('job.index')
            ->with('successUpdate', 'تم تعديل الوظيفة بنجاح');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('job.index')->with('success', 'تم حذف الوظيفة بنجاح');
    }
}
