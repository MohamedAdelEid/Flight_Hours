<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrewRequest;
use App\Models\Aircraft;
use App\Models\Crew;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrewController extends Controller
{

    public function index()
    {
        return view('employee.crew.index',[
            'crews' => Crew::with('user')->orderByDesc('created_at')->get()
        ]);
    }

    public function create()
    {
        return view('employee.crew.add', [
            'jobs' => Job::all(),
            'job_types' => JobType::all()
        ]);
    }


    public function store(CrewRequest $crewRequest)
    {
        Crew::create(array_merge($crewRequest->validated(),[
            'user_id' => Auth::id()
        ]));
        return redirect()->route('crew.index')
                    ->with('successCreate','تم اضافة عضو الطاقم بنجاح');
    }

    public function show(Crew $crew)
    {
        return view('employee.crew.show',['crew'=>$crew]);
    }

    public function edit(Crew $crew)
    {
        return view('employee.crew.edit',[
            'crew' => $crew,
            'jobs' => Job::all(),
            'job_types' => JobType::all()
        ]);
    }

    public function update(CrewRequest $crewRequest, Crew $crew)
    {
        $crew->update($crewRequest->validated());
        return redirect()->route('crew.index')
            ->with('successUpdate', 'تم التعديل علي عضو الطاقم بنجاح');
    }

    public function destroy(Crew $crew)
    {
        $crew->delete();
        return redirect()->route('crew.index')
            ->with('success', 'تم حذف عضو الطاقم بنجاح');
    }

    public function getJobsByType($type_id)
    {
        $jobs = Job::where('type_id', $type_id)->get();
        return response()->json($jobs);
    }
}
