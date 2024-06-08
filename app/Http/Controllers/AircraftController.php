<?php

namespace App\Http\Controllers;

use App\Http\Requests\AircraftRequest;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AircraftController extends Controller
{
    public function index()
    {
        $aircrafts = Aircraft::all()->sortByDesc('created_at');
        return view('user.aircraft.index', ['aircrafts' => $aircrafts]);
    }

    public function create()
    {
        return view('user.aircraft.add');
    }

    public function store(AircraftRequest $aircraftRequest)
    {
        $aircraftRequest->merge([
            'user_id' => Auth::guard('web')->id(),
        ]);
        Aircraft::create($aircraftRequest->validated());
        return redirect()->route('aircraft.create')
            ->with('success', 'Aircraft Created Successfully');
    }

    public function show(Aircraft $aircraft)
    {
        return view('user.aircraft.show', ['aircraft' => $aircraft]);
    }

    public function edit(Aircraft $aircraft)
    {
        return view('user.aircraft.edit', ['aircraft' => $aircraft]);
    }

    public function update(AircraftRequest $aircraftRequest, Aircraft $aircraft)
    {
        $aircraft->update($aircraftRequest->validated());
        return redirect()->route('aircraft.index')
            ->with('success', 'Aircraft Updated Successfully');
    }

    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();
        return redirect()->route('aircraft.index')
            ->with('success', 'Aircraft Deleted Successfully');
    }
}
