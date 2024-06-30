<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Crew;
use App\Models\CrewFlight;
use App\Models\Flight;
use App\Models\FlightHour;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{

    public function index()
    {
        return view('employee.flight.index', [
            'flight' => Flight::with('flightHours')
                ->orderByDesc('created_at')->get()
        ]);
    }
    public function create()
    {
        return view('employee.flight.add', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
        ]);
    }
    public function store(FlightRequest $flightRequest)
    {
        $data = $flightRequest->validated();
        try {
            $departureFlight = Flight::create([
                'flight_number' => $data['departure_flight_number'],
                'flight_date' => $data['departure_flight_date'],
                'aircraft_id' => $data['departure_aircraft_id'],
                'origin_airport_id' => $data['departure_origin_airport_id'],
                'destination_airport_id' => $data['departure_destination_airport_id'],
                'departure_time' => $data['departure_departure_time'],
                'arrival_time' => $data['departure_arrival_time'],
                'aircraft_number' => $data['departure_aircraft_number'],
                'flight_type' => $data['departure_flight_type'],
                'user_id' => auth()->user()->id,
            ]);
            FlightHour::calcFlightHours($departureFlight);
            $returnFlight = Flight::create([
                'flight_number' => $data['return_flight_number'],
                'flight_date' => $data['return_flight_date'],
                'aircraft_id' => $data['return_aircraft_id'],
                'origin_airport_id' => $data['return_origin_airport_id'],
                'destination_airport_id' => $data['return_destination_airport_id'],
                'departure_time' => $data['return_departure_time'],
                'arrival_time' => $data['return_arrival_time'],
                'aircraft_number' => $data['return_aircraft_number'],
                'flight_type' => $data['return_flight_type'],
                'user_id' => auth()->user()->id,
            ]);
            FlightHour::calcFlightHours($returnFlight);
            $crews = $data['crew_id'];
            foreach ($crews as $crewId) {
                CrewFlight::create([
                    'flight_id' => $departureFlight->id,
                    'crew_id' => $crewId,
                    'user_id' => auth()->user()->id,
                ]);
                CrewFlight::create([
                    'flight_id' => $returnFlight->id,
                    'crew_id' => $crewId,
                    'user_id' => auth()->user()->id,
                ]);
            }
            if ($departureFlight && $returnFlight) {
                return redirect()->route('flight.index')->with('successCreate', 'تم اضافة الرحلتين بنجاح');
            } else {
                return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء إضافة الرحلتين. الرجاء المحاولة مرة أخرى.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء إضافة الرحلتين: ' . $e->getMessage());
        }
    }

    public function edit(Flight $flight)
    {
        $crewFlight = CrewFlight::where('flight_id', $flight->id)->get();

        return view('employee.flight.edit', [
            'flight' => $flight,
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::all(),
            'crewFlights' => $crewFlight,
        ]);
    }
    public function update(Request $request, Flight $flight)
    {
//        dd($flight);
        $validatedData = $request->validate([
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
            'flight_date' => 'required|date',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_type' => 'required|string',
            'flight_number' => 'required|integer',
            'aircraft_number' => 'required|integer',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
        ]);

        $flight->update($validatedData);
        $flight->refresh();
        $departureTime = Carbon::parse($flight->departure_time);
        $arrivalTime = Carbon::parse($flight->arrival_time);
        $diff = $arrivalTime->diff($departureTime);
        $hours = $diff->h + ($diff->i / 60);

        $flightHours = FlightHour::where('flight_id',$flight->id)->first();
        if ($flightHours){
            $flightHours->update([
                'hours' => $hours
            ]);
        }else{
            FlightHour::create([
                'aircraft_id' => $flight->aircraft_id,
                'flight_id' => $flight->id,
                'hours' => $hours
            ]);
        }
        return redirect()->route('flight.index')->with('success', 'تم تعديل الرحلة بنجاح');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flight.index')
            ->with('success', 'تم حذف الرحلة بنجاح');
    }
    public function getCrewsByJob($job_id)
    {
        $crews = Crew::where('job_id', $job_id)->get();
        return response()->json($crews);
    }

}
