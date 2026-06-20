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
use Illuminate\Support\Str;

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
            'crews' => Crew::with('job')->get(),
        ]);
    }
    // create unloaded flight
    public function createUnloadedFlight()
    {
        return view('employee.flight.add.sub-flights.unloaded-flight', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::with('job')->get(),
        ]);
    }
    // create simulated flight
    public function createSimulatedFlight()
    {
        return view('employee.flight.add.sub-flights.simulated-flight', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::with('job')->get(),
        ]);
    }
    // create flying test
    public function createFlyingTest()
    {
        return view('employee.flight.add.sub-flights.flying-test', [
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::with('job')->get(),
        ]);
    }
    public function store(FlightRequest $flightRequest)
    {
        $data = $flightRequest->validated();

        try {
            $roundTripId = (string) \Illuminate\Support\Str::uuid();

            $departureFlight = Flight::create([
                'round_trip_id' => $roundTripId,
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
                'round_trip_id' => $roundTripId,
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
            $job_ids = $data['job_id'];
            foreach ($financial_numbers as $index => $financial_number) {
                $crew_id = Crew::where('financial_number', $financial_number)->value('id');
                if (!$crew_id) {
                    throw new \Exception('Invalid crew ID for financial number: ' . $financial_number);
                }

                $job_id = $job_ids[$index] ?? null;

                CrewNormalFlights::create([
                    'flight_id' => $departureFlight->id,
                    'crew_id' => $crew_id,
                    'job_id' => $job_id,
                    'user_id' => auth()->user()->id,
                ]);

                CrewNormalFlights::create([
                    'flight_id' => $returnFlight->id,
                    'crew_id' => $crew_id,
                    'job_id' => $job_id,
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
        $departureFlight = $flight;
        $returnFlight = null;
        $crewFlights = collect();

        if ($flight->round_trip_id) {
            $pair = Flight::where('round_trip_id', $flight->round_trip_id)
                ->where('id', '!=', $flight->id)
                ->first();

            $departureFlight = $flight->origin_airport_id < ($pair?->origin_airport_id ?? $flight->origin_airport_id) ? $flight : $pair;
            $returnFlight = $flight->origin_airport_id < ($pair?->origin_airport_id ?? $flight->origin_airport_id) ? $pair : $flight;

            if (!$returnFlight) {
                $returnFlight = $departureFlight;
            }

            $crewFlights = CrewNormalFlights::where('flight_id', $departureFlight->id)->with('crew.job', 'job')->get();
        } else {
            $crewFlights = CrewNormalFlights::where('flight_id', $flight->id)->with('crew.job', 'job')->get();
        }

        return view('employee.flight.edit', [
            'departureFlight' => $departureFlight,
            'returnFlight' => $returnFlight,
            'aircrafts' => Aircraft::all(),
            'airports' => Airport::all(),
            'jobs' => Job::all(),
            'crews' => Crew::with('job')->get(),
            'crewFlights' => $crewFlights,
        ]);
    }
    public function update(UpdateFlightRequest $request, Flight $flight)
    {
        $data = $request->validated();

        try {
            if ($flight->round_trip_id) {
                $returnFlight = Flight::where('round_trip_id', $flight->round_trip_id)
                    ->where('id', '!=', $flight->id)
                    ->first();
            } else {
                $returnFlight = null;
            }

            $flight->update([
                'flight_number' => $data['departure_flight_number'],
                'flight_date' => $data['departure_flight_date'],
                'aircraft_id' => $data['departure_aircraft_id'],
                'origin_airport_id' => $data['departure_origin_airport_id'],
                'destination_airport_id' => $data['departure_destination_airport_id'],
                'departure_time' => $data['departure_departure_time'],
                'arrival_time' => $data['departure_arrival_time'],
                'aircraft_number' => $data['departure_aircraft_number'],
            ]);

            $this->recalcHours($flight);

            if ($returnFlight) {
                $returnFlight->update([
                    'flight_number' => $data['return_flight_number'],
                    'flight_date' => $data['return_flight_date'],
                    'aircraft_id' => $data['return_aircraft_id'],
                    'origin_airport_id' => $data['return_origin_airport_id'],
                    'destination_airport_id' => $data['return_destination_airport_id'],
                    'departure_time' => $data['return_departure_time'],
                    'arrival_time' => $data['return_arrival_time'],
                    'aircraft_number' => $data['return_aircraft_number'],
                ]);

                $this->recalcHours($returnFlight);
            }

            $flightId = $departureFlightId = $flight->id;
            $returnFlightId = $returnFlight?->id ?? $flightId;

            CrewNormalFlights::where('flight_id', $flightId)->delete();
            if ($returnFlightId !== $flightId) {
                CrewNormalFlights::where('flight_id', $returnFlightId)->delete();
            }

            $financial_numbers = $data['financial_number'];
            $job_ids = $data['job_id'];
            foreach ($financial_numbers as $index => $financial_number) {
                $crew_id = Crew::where('financial_number', $financial_number)->value('id');
                if (!$crew_id) {
                    throw new \Exception('Invalid crew ID for financial number: ' . $financial_number);
                }

                $job_id = $job_ids[$index] ?? null;

                CrewNormalFlights::create([
                    'flight_id' => $flightId,
                    'crew_id' => $crew_id,
                    'job_id' => $job_id,
                    'user_id' => auth()->user()->id,
                ]);

                if ($returnFlightId !== $flightId) {
                    CrewNormalFlights::create([
                        'flight_id' => $returnFlightId,
                        'crew_id' => $crew_id,
                        'job_id' => $job_id,
                        'user_id' => auth()->user()->id,
                    ]);
                }
            }

            return redirect()->route('flight.index')->with('success', 'تم تعديل الرحلة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء تعديل الرحلة: ' . $e->getMessage());
        }
    }

    private function recalcHours(Flight $flight)
    {
        $departureTime = Carbon::parse($flight->departure_time);
        $arrivalTime = Carbon::parse($flight->arrival_time);
        $diff = $arrivalTime->diff($departureTime);
        $hours = $diff->h + ($diff->i / 60);

        $flightHours = FlightHour::where('flight_id', $flight->id)->first();
        if ($flightHours) {
            $flightHours->update(['hours' => $hours]);
        } else {
            FlightHour::create([
                'aircraft_id' => $flight->aircraft_id,
                'flight_id' => $flight->id,
                'hours' => $hours
            ]);
        }
    }

    public function approve(Flight $flight)
    {
        $data = [
            'status' => Flight::STATUS_COMPLETED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ];
        $flight->update($data);

        if ($flight->round_trip_id) {
            Flight::where('round_trip_id', $flight->round_trip_id)
                ->where('id', '!=', $flight->id)
                ->update($data);
        }

        return redirect()->route('flight.index')->with('success', 'تم اعتماد الرحلة بنجاح');
    }

    public function reject(Request $request, Flight $flight)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);
        $data = [
            'status' => Flight::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ];
        $flight->update($data);

        if ($flight->round_trip_id) {
            Flight::where('round_trip_id', $flight->round_trip_id)
                ->where('id', '!=', $flight->id)
                ->update($data);
        }

        return redirect()->route('flight.index')->with('success', 'تم رفض الرحلة');
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
