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

    public function pilotHoursReport(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $minHours = $request->get('min_hours');

        // Base query - join crews with flights via crews_flights table
        $flightsQuery = DB::table('flights')
            ->join('crews_flights', 'flights.id', '=', 'crews_flights.flight_id')
            ->join('crews', 'crews_flights.crew_id', '=', 'crews.id')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                'crews.id as crew_id',
                'crews.first_name',
                'crews.last_name',
                'flights.flight_date',
                'flight_hours.hours'
            );

        // Apply date filters
        if ($dateFrom) {
            $flightsQuery->where('flights.flight_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $flightsQuery->where('flights.flight_date', '<=', $dateTo);
        }

        $flightsData = $flightsQuery->get();

        // Aggregate per pilot
        $pilotsData = [];
        $grouped = $flightsData->groupBy('crew_id');

        foreach ($grouped as $crewId => $flights) {
            $totalHours = $flights->sum('hours');
            $totalFlights = $flights->count();
            $avgHours = $totalFlights > 0 ? round($totalHours / $totalFlights, 1) : 0;
            $firstFlight = $flights->first();

            $pilotsData[] = [
                'crew_id' => $crewId,
                'pilot_name' => $firstFlight->first_name . ' ' . $firstFlight->last_name,
                'total_hours' => round($totalHours, 1),
                'total_flights' => $totalFlights,
                'avg_hours' => $avgHours,
            ];
        }

        // Filter by minimum hours
        if ($minHours) {
            $pilotsData = array_filter($pilotsData, function ($pilot) use ($minHours) {
                return $pilot['total_hours'] >= floatval($minHours);
            });
            $pilotsData = array_values($pilotsData);
        }

        // Sort by total hours descending
        usort($pilotsData, function ($a, $b) {
            return $b['total_hours'] <=> $a['total_hours'];
        });

        // Summary stats
        $totalPilots = count($pilotsData);
        $totalHoursSum = array_sum(array_column($pilotsData, 'total_hours'));
        $avgPerPilot = $totalPilots > 0 ? round($totalHoursSum / $totalPilots, 1) : 0;
        $topPilot = !empty($pilotsData) ? $pilotsData[0] : null;

        // Monthly trend data
        $monthlyQuery = DB::table('flights')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                DB::raw('MONTH(flight_date) as month'),
                DB::raw('YEAR(flight_date) as year'),
                DB::raw('SUM(hours) as total_hours')
            )
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month');

        $monthlyData = $monthlyQuery->get();
        $monthlyLabels = [];
        $monthlyHours = [];

        $monthNames = ['', 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        foreach ($monthlyData as $m) {
            $monthlyLabels[] = $monthNames[$m->month] . ' ' . $m->year;
            $monthlyHours[] = floatval($m->total_hours);
        }

        // Distribution buckets
        $distribution = [0, 0, 0, 0]; // <50, 50-100, 100-200, >200
        foreach ($pilotsData as $pilot) {
            $h = $pilot['total_hours'];
            if ($h < 50) $distribution[0]++;
            elseif ($h < 100) $distribution[1]++;
            elseif ($h < 200) $distribution[2]++;
            else $distribution[3]++;
        }

        return view('employee.reports.pilot_hours', compact(
            'pilotsData',
            'totalPilots',
            'totalHoursSum',
            'avgPerPilot',
            'topPilot',
            'monthlyLabels',
            'monthlyHours',
            'distribution',
            'dateFrom',
            'dateTo',
            'minHours'
        ));
    }

    public function aircraftHoursReport(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $aircraftType = $request->get('aircraft_type');
        $statusFilter = $request->get('status');
        $minHours = $request->get('min_hours');

        // Base query - join flights with aircrafts and flight_hours
        $flightsQuery = DB::table('flights')
            ->join('aircrafts', 'flights.aircraft_id', '=', 'aircrafts.id')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                'aircrafts.id as aircraft_id',
                'aircrafts.aircraft_name',
                'aircrafts.aircraft_code',
                'aircrafts.manufacturer',
                'aircrafts.status as aircraft_status',
                'flights.flight_date',
                'flight_hours.hours'
            );

        // Apply filters
        if ($dateFrom) {
            $flightsQuery->where('flights.flight_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $flightsQuery->where('flights.flight_date', '<=', $dateTo);
        }
        if ($aircraftType) {
            $flightsQuery->where('aircrafts.manufacturer', '=', $aircraftType);
        }
        if ($statusFilter) {
            $flightsQuery->where('aircrafts.status', '=', $statusFilter);
        }

        $flightsData = $flightsQuery->get();

        // Aggregate per aircraft
        $aircraftData = [];
        $grouped = $flightsData->groupBy('aircraft_id');

        $maxHours = 0;
        foreach ($grouped as $aircraftId => $flights) {
            $totalHours = $flights->sum('hours');
            $totalFlights = $flights->count();
            $avgHours = $totalFlights > 0 ? round($totalHours / $totalFlights, 1) : 0;
            $lastFlight = $flights->max('flight_date');
            $firstFlight = $flights->min('flight_date');
            $firstAircraft = $flights->first();

            $maxHours = max($maxHours, $totalHours);

            $aircraftData[] = [
                'aircraft_id' => $aircraftId,
                'aircraft_name' => $firstAircraft->aircraft_name,
                'aircraft_code' => $firstAircraft->aircraft_code,
                'manufacturer' => $firstAircraft->manufacturer,
                'aircraft_status' => $firstAircraft->aircraft_status,
                'total_hours' => round($totalHours, 1),
                'total_flights' => $totalFlights,
                'avg_hours' => $avgHours,
                'last_flight' => $lastFlight,
                'first_flight' => $firstFlight,
            ];
        }

        // Filter by minimum hours
        if ($minHours) {
            $aircraftData = array_filter($aircraftData, function ($ac) use ($minHours) {
                return $totalHours = $ac['total_hours'] >= floatval($minHours);
            });
            $aircraftData = array_values($aircraftData);
        }

        // Sort by total hours
        usort($aircraftData, function ($a, $b) {
            return $b['total_hours'] <=> $a['total_hours'];
        });

        // Summary stats
        $totalAircraft = count($aircraftData);
        $totalHoursSum = array_sum(array_column($aircraftData, 'total_hours'));
        $avgPerAircraft = $totalAircraft > 0 ? round($totalHoursSum / $totalAircraft, 1) : 0;
        $activeCount = count(array_filter($aircraftData, fn($ac) => $ac['aircraft_status'] === 'active'));
        $topAircraft = !empty($aircraftData) ? $aircraftData[0] : null;

        // Get unique aircraft types
        $aircraftTypes = DB::table('aircrafts')
            ->whereNotNull('manufacturer')
            ->distinct()
            ->pluck('manufacturer')
            ->toArray();

        // Monthly trend data
        $monthlyQuery = DB::table('flights')
            ->join('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                DB::raw('MONTH(flight_date) as month'),
                DB::raw('YEAR(flight_date) as year'),
                DB::raw('SUM(hours) as total_hours'),
                DB::raw('COUNT(*) as total_flights')
            )
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month');

        $monthlyData = $monthlyQuery->get();
        $monthlyLabels = [];
        $monthlyHours = [];
        $monthlyFlights = [];

        $monthNames = ['', 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        foreach ($monthlyData as $m) {
            $monthlyLabels[] = $monthNames[$m->month] . ' ' . $m->year;
            $monthlyHours[] = floatval($m->total_hours);
            $monthlyFlights[] = intval($m->total_flights);
        }

        // Type breakdown
        $typeBreakdown = [];
        $typeGrouped = $flightsData->groupBy('manufacturer');
        foreach ($typeGrouped as $type => $flights) {
            $typeBreakdown[] = [
                'type' => $type ?: 'غير محدد',
                'hours' => round($flights->sum('hours'), 1),
                'count' => $flights->groupBy('aircraft_id')->count()
            ];
        }
        usort($typeBreakdown, fn($a, $b) => $b['hours'] <=> $a['hours']);

        // Distribution buckets
        $utilization = [0, 0, 0, 0]; // <100, 100-300, 300-600, >600
        foreach ($aircraftData as $ac) {
            $h = $ac['total_hours'];
            if ($h < 100) $utilization[0]++;
            elseif ($h < 300) $utilization[1]++;
            elseif ($h < 600) $utilization[2]++;
            else $utilization[3]++;
        }

        return view('employee.reports.aircraft_hours', compact(
            'aircraftData',
            'totalAircraft',
            'totalHoursSum',
            'avgPerAircraft',
            'activeCount',
            'topAircraft',
            'monthlyLabels',
            'monthlyHours',
            'monthlyFlights',
            'typeBreakdown',
            'utilization',
            'aircraftTypes',
            'dateFrom',
            'dateTo',
            'aircraftType',
            'statusFilter',
            'minHours',
            'maxHours'
        ));
    }
}
