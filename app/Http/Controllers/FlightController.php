<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{

    public function index()
    {
       return view('employee.flight.index',[
           'flight'=> Flight::with('flightHours')
               ->orderByDesc('created_at')->get()
       ]);
    }

    public function create()
    {
        return view('employee.flight.add',[
            'aircrafts'=> Aircraft::all(),
            'airports' => Airport::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlightRequest $flightRequest)
    {
        $flight = Flight::create(array_merge($flightRequest->validated(),[
            'user_id' => Auth::id()
        ]));
        $departureTime = Carbon::parse($flight->departure_time);
        $arrivalTime = Carbon::parse($flight->arrival_time);
        $diff = $departureTime->diff($arrivalTime);
        $hours = $diff->h + ($diff->i / 60);
        FlightHour::create([
            'aircraft_id' => $flight->aircraft_id,
            'flight_id' => $flight->id,
            'hours' => $hours
        ]);
        return redirect()->route('flight.index')->with('success','تم اضافة الرحلة بنجاح ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        return view('employee.flight.edit', [
            'flight' => $flight,
            'aircrafts'=> Aircraft::all(),
            'airports' => Airport::all(),
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FlightRequest $flightRequest,Flight $flight)
    {
        $flight->update($flightRequest->validated());
        return redirect()->route('flight.index')
            ->with('success', 'تم التعديل علي الرحلة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flight.index')
            ->with('success', 'تم حذف الرحلة بنجاح');
    }
}
