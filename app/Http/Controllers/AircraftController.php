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
        return view('employee.aircraft.index', ['aircrafts' => $aircrafts]);
    }

    public function create()
    {
        return view('employee.aircraft.add');
    }

    public function store(AircraftRequest $aircraftRequest)
    {
        Aircraft::create(array_merge($aircraftRequest->validated(), [
            'user_id' => Auth::id(),
        ]));
        return redirect()->route('aircraft.index')
            ->with('successCreate', 'تم اضافة الطائرة  بنجاح');
    }

    public function show(Aircraft $aircraft)
    {
        return view('employee.aircraft.show', ['aircraft' => $aircraft]);
    }

    public function edit(Aircraft $aircraft)
    {
        return view('employee.aircraft.edit', ['aircraft' => $aircraft]);
    }

    public function update(AircraftRequest $aircraftRequest, Aircraft $aircraft)
    {
        $aircraft->update($aircraftRequest->validated());
        return redirect()->route('aircraft.index')
            ->with('successUpdate', 'تم التعديل علي الطائرة بنجاح');
    }

    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();
        return redirect()->route('aircraft.index')
            ->with('success', 'تم حذف الطائرة بنجاح');
    }
}
