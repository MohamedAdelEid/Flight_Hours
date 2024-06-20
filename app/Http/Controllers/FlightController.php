<?php

namespace App\Http\Controllers;

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
                'landing_time' => $data['departure_landing_time'],
                'departure_time' => $data['departure_departure_time'],
                'arrival_time' => $data['departure_arrival_time'],
                'door_closed_at' => $data['departure_door_closed_at'],
                'door_opened_at' => $data['departure_door_opened_at'],
                'user_id' => auth()->user()->id,
            ]);
            FlightHour::calcFlightHours($departureFlight);
            $returnFlight = Flight::create([
                'flight_number' => $data['return_flight_number'],
                'flight_date' => $data['return_flight_date'],
                'aircraft_id' => $data['return_aircraft_id'],
                'origin_airport_id' => $data['return_origin_airport_id'],
                'landing_time' => $data['return_landing_time'],
                'destination_airport_id' => $data['return_destination_airport_id'],
                'departure_time' => $data['return_departure_time'],
                'arrival_time' => $data['return_arrival_time'],
                'door_closed_at' => $data['return_door_closed_at'],
                'door_opened_at' => $data['return_door_opened_at'],
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


    public function update(Request $updateFlightRequest, Flight $flight)
    {

        $data = $updateFlightRequest->all();
        try {
            $flight->update([
                'flight_number' => $data['flight_number'],
                'flight_date' => $data['flight_date'],
                'aircraft_id' => $data['aircraft_id'],
                'origin_airport_id' => $data['origin_airport_id'],
                'destination_airport_id' => $data['destination_airport_id'],
                'landing_time' => $data['landing_time'],
                'departure_time' => $data['departure_time'],
                'arrival_time' => $data['arrival_time'],
                'door_closed_at' => $data['door_closed_at'],
                'door_opened_at' => $data['door_opened_at'],
            ]);
            if (isset($data['crew_id'])) {
                CrewFlight::where('flight_id', $flight->id)->delete();
            foreach ($data['crew_id'] as $crewId) {
                    CrewFlight::create([
                        'flight_id' => $flight->id,
                        'crew_id' => $crewId,
                        'user_id' => auth()->user()->id,
                    ]);
                }
            }

            return redirect()->route('flight.index')
                ->with('success', 'تم التعديل علي الرحلة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء تعديل الرحلة: ' . $e->getMessage());
        }
    }



//    public function update(Request $request, Flight $flight)
//    {
//        $validator = Validator::make($request->all(), [
//            'origin_airport_id' => 'required|exists:airports,id',
//            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
//            'aircraft_id' => 'required|exists:aircrafts,id',
//            'flight_number' => 'required|numeric',
//            'flight_date' => 'required|date',
//            'door_closed_at' => 'required|date_format:H:i:s',
//            'departure_time' => 'required|date_format:H:i:s|after:door_closed_at',
//            'landing_time' => 'required|date_format:H:i:s|after:departure_time',
//            'door_opened_at' => 'required|date_format:H:i:s|after:landing_time',
//            'arrival_time' => 'required|date_format:H:i:s|after:door_opened_at',
//            'job_id.*' => 'required|exists:jobs,id',
//            'crew_id.*' => 'required|exists:crews,id',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//        }
//
//        try {
//            $flight->update($validator->validated());
//
//            if ($request->has('crew_id')) {
//                CrewFlight::where('flight_id', $flight->id)->delete();
//                foreach ($request->input('crew_id') as $crewId) {
//                    CrewFlight::create([
//                        'flight_id' => $flight->id,
//                        'crew_id' => $crewId,
//                        'user_id' => auth()->user()->id,
//                    ]);
//                }
//            }
//
//            return redirect()->route('flight.index')
//                ->with('success', 'تم التعديل علي الرحلة بنجاح');
//        } catch (\Exception $e) {
//            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء تعديل الرحلة: ' . $e->getMessage());
//        }
//    }

    /**
     * Remove the specified resource from storage.
     */
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
