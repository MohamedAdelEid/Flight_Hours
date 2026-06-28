<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\AircraftRequest;
use App\Models\Aircraft;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class AircraftController extends Controller
{
    public function index()
    {
        return view('employee.aircraft.index', [
            'aircrafts' => Aircraft::orderByDesc('created_at')->get(),
        ]);
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

        return redirect()->route('aircraft.index')->with('successCreate', 'تم إضافة الطائرة بنجاح');
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

        return redirect()->route('aircraft.index')->with('successUpdate', 'تم تعديل الطائرة بنجاح');
    }

    public function destroy(Aircraft $aircraft)
    {
        try {
            $aircraft->delete();
        } catch (QueryException) {
            return redirect()->route('aircraft.index')->with('error', 'لا يمكن حذف الطائرة لأنها مرتبطة برحلات أو ساعات طيران');
        }

        return redirect()->route('aircraft.index')->with('success', 'تم حذف الطائرة بنجاح');
    }
}