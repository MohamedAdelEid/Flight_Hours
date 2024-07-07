<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Crew;
use App\Models\CrewFlight;
use App\Models\CrewNormalFlights;
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
    // create normal flight
    public function createNormalFlight()
    {
        return view('employee.flight.add.main-flight', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
        ]);
    }
    // create unloaded flight
    public function createUnloadedFlight()
    {
        return view('employee.flight.add.sub-flights.unloaded-flight', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
        ]);
    }
    // create simulated flight
    public function createSimulatedFlight()
    {
        return view('employee.flight.add.sub-flights.simulated-flight', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
        ]);
    }
    // create flying test
    public function createFlyingTest()
    {
        return view('employee.flight.add.sub-flights.flying-test', [
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
                'user_id' => auth()->user()->id,
            ]);
            FlightHour::calcFlightHours($returnFlight);

            $financial_numbers = $data['financial_number'];
            foreach ($financial_numbers as $financial_number) {
                $crew_id = Crew::where('financial_number', $financial_number)->value('id');
                if (!$crew_id) {
                    throw new \Exception('Invalid crew ID for financial number: ' . $financial_number);
                }

                CrewNormalFlights::create([
                    'flight_id' => $departureFlight->id,
                    'crew_id' => $crew_id,
                    'user_id' => auth()->user()->id,
                ]);

                CrewNormalFlights::create([
                    'flight_id' => $returnFlight->id,
                    'crew_id' => $crew_id,
                    'user_id' => auth()->user()->id,
                ]);
            }

            if ($departureFlight && $returnFlight) {
                return redirect()->route('flight.index')->with('successCreate', 'تم اضافة الرحلة بنجاح');
            } else {
                return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء إضافة الرحلتين. الرجاء المحاولة مرة أخرى.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء إضافة الرحلتين: ' . $e->getMessage());
        }
    }
    public function edit(Flight $flight)
    {

        $crewFlight = CrewNormalFlights::where('flight_id', $flight->id)->get();

        return view('employee.flight.edit', [
            'flight' => $flight,
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::all(),
            'crewFlights' => $crewFlight,
        ]);
    }
    public function update(UpdateFlightRequest $request, Flight $flight)
    {
        $validatedData = $request->validated();
        $flight->update($validatedData);
        $flight->refresh();
        $departureTime = Carbon::parse($flight->departure_time);
        $arrivalTime = Carbon::parse($flight->arrival_time);
        $diff = $arrivalTime->diff($departureTime);
        $hours = $diff->h + ($diff->i / 60);

        $flightHours = FlightHour::where('flight_id', $flight->id)->first();
        if ($flightHours) {
            $flightHours->update([
                'hours' => $hours
            ]);
        } else {
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
    public function getCrewsByFinancialNumber($financialNumber)
    {
        $crew = Crew::where('financial_number', $financialNumber)
            ->join('jobs', 'crews.job_id', '=', 'jobs.id')
            ->get();

        return response()->json($crew);
    }


}
