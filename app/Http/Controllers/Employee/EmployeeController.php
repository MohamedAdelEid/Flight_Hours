<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        // Total flights count
        $totalFlights = DB::table('flights')->count();

        // Total flight hours
        $totalHours = DB::table('flight_hours')->sum('hours');

        // Active pilots (crew members with pilot job type)
        $activePilots = DB::table('crews')
            ->join('jobs', 'crews.job_id', '=', 'jobs.id')
            ->join('job_types', 'crews.job_type', '=', 'job_types.id')
            ->where('crews.status', 'active')
            ->where('job_types.id', 1)  // Assuming 1 is the job type ID for pilots
            ->count();

        // Active aircraft
        $activeAircraft = DB::table('aircrafts')
            ->where('status', 'active')
            ->count();

        // Completion rate
        $completedFlights = DB::table('flights')
            ->where('status', 'completed')
            ->count();
        $completionRate = $totalFlights > 0 ? round(($completedFlights / $totalFlights) * 100, 1) : 0;

        // Average flight time
        $avgFlightTime = $totalFlights > 0
            ? round(DB::table('flight_hours')->avg('hours'), 1)
            : 0;

        // Monthly flight hours for the current year
        $currentYear = Carbon::now()->year;
        $monthlyHours = DB::table('flights')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                DB::raw('MONTH(flight_date) as month'),
                DB::raw('SUM(hours) as total_hours')
            )
            ->whereYear('flight_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function ($item) {
                return $item->total_hours;
            })
            ->toArray();

        // Fill in missing months with zero
        $monthlyHoursData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyHoursData[$i] = $monthlyHours[$i] ?? 0;
        }

        // Monthly flight counts
        $monthlyFlights = DB::table('flights')
            ->select(
                DB::raw('MONTH(flight_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('flight_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();

        // Fill in missing months with zero
        $monthlyFlightsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyFlightsData[$i] = $monthlyFlights[$i] ?? 0;
        }

        // Flight types distribution
        $flightTypes = DB::table('flights')
            ->select('flight_type', DB::raw('COUNT(*) as count'))
            ->groupBy('flight_type')
            ->get()
            ->keyBy('flight_type')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();

        // Top routes
        $topRoutes = DB::table('flights')
            ->join('airports as origin', 'flights.origin_airport_id', '=', 'origin.id')
            ->join('airports as destination', 'flights.destination_airport_id', '=', 'destination.id')
            ->select(
                'origin.airport_name as origin',
                'destination.airport_name as destination',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(flight_hours.hours) as total_hours')
            )
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->groupBy('origin.airport_name', 'destination.airport_name')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Top pilots by flight hours
        $topPilots = DB::table('crews')
            ->join('crew_normal_flights', 'crews.id', '=', 'crew_normal_flights.crew_id')
            ->join('flights', 'crew_normal_flights.flight_id', '=', 'flights.id')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                'crews.first_name',
                'crews.last_name',
                DB::raw('SUM(flight_hours.hours) as total_hours'),
                DB::raw('COUNT(DISTINCT flights.id) as flight_count')
            )
            ->groupBy('crews.id', 'crews.first_name', 'crews.last_name')
            ->orderBy('total_hours', 'desc')
            ->limit(5)
            ->get();

        // Aircraft utilization
        $aircraftUtilization = DB::table('aircrafts')
            ->join('flight_hours', 'aircrafts.id', '=', 'flight_hours.aircraft_id')
            ->select(
                'aircrafts.aircraft_name',
                DB::raw('SUM(flight_hours.hours) as total_hours')
            )
            ->groupBy('aircrafts.id', 'aircrafts.aircraft_name')
            ->orderBy('total_hours', 'desc')
            ->limit(5)
            ->get();

        // Recent flights
        $recentFlights = DB::table('flights')
            ->join('aircrafts', 'flights.aircraft_id', '=', 'aircrafts.id')
            ->join('airports as origin', 'flights.origin_airport_id', '=', 'origin.id')
            ->join('airports as destination', 'flights.destination_airport_id', '=', 'destination.id')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                'flights.flight_number',
                'flights.flight_type',
                'aircrafts.aircraft_name',
                'origin.airport_name as origin',
                'destination.airport_name as destination',
                'flights.flight_date',
                'flight_hours.hours',
                'flights.status'
            )
            ->orderBy('flights.flight_date', 'desc')
            ->limit(5)
            ->get();

        return view('employee.index', compact(
            'totalFlights',
            'totalHours',
            'activePilots',
            'activeAircraft',
            'completionRate',
            'avgFlightTime',
            'monthlyHoursData',
            'monthlyFlightsData',
            'flightTypes',
            'topRoutes',
            'topPilots',
            'aircraftUtilization',
            'recentFlights'
        ));
    }
}
