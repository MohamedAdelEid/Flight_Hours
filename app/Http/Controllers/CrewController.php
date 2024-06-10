<?php

namespace App\Http\Controllers;

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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrewRequest $crewRequest)
    {
        Crew::create(array_merge($crewRequest->validated(),[
            'user_id' => Auth::id()
        ]));
        return redirect()->route('crew.index')
                    ->with('success','Crew Member Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        return view('employee.crew.show',['crew'=>$crew]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crew $crew)
    {
        return view('employee.crew.edit',[
            'crew' => $crew,
            'jobs' => Job::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrewRequest $crewRequest, Crew $crew)
    {
        $crew->update($crewRequest->validated());
        return redirect()->route('crew.index')
            ->with('success', 'Crew Member Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crew $crew)
    {
        $crew->delete();
        return redirect()->route('crew.index')
            ->with('success', 'Crew Member Deleted Successfully');
    }
}
