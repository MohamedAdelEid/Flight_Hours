<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $flightScope = DB::table('flights');
        $this->applyDateFilter($flightScope, $dateFrom, $dateTo, 'flight_date');

        $hoursScope = DB::table('flights')
            ->leftJoin('flight_hours', 'flights.id', '=', 'flight_hours.flight_id');
        $this->applyDateFilter($hoursScope, $dateFrom, $dateTo, 'flights.flight_date');

        $stats = [
            'flights' => (clone $flightScope)->count(),
            'hours' => round((float) (clone $hoursScope)->sum('flight_hours.hours'), 1),
            'aircraft' => DB::table('aircrafts')->count(),
            'airports' => DB::table('airports')->count(),
            'crew' => DB::table('crews')->count(),
            'jobs' => DB::table('jobs')->count(),
            'users' => DB::table('users')->count(),
        ];

        $flightStatus = (clone $flightScope)
            ->select(DB::raw('COALESCE(status, "unknown") as status'), DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $monthlyFlights = (clone $flightScope)
            ->select(DB::raw('YEAR(flight_date) as year'), DB::raw('MONTH(flight_date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $topAircraft = DB::table('aircrafts')
            ->leftJoin('flight_hours', 'aircrafts.id', '=', 'flight_hours.aircraft_id')
            ->select('aircrafts.aircraft_name', 'aircrafts.aircraft_code', 'aircrafts.registration_number', DB::raw('COALESCE(SUM(flight_hours.hours), 0) as total_hours'))
            ->groupBy('aircrafts.id', 'aircrafts.aircraft_name', 'aircrafts.aircraft_code', 'aircrafts.registration_number')
            ->orderByDesc('total_hours')
            ->limit(10)
            ->get();

        $topCrew = DB::table('crews')
            ->leftJoin('crew_normal_flights', 'crews.id', '=', 'crew_normal_flights.crew_id')
            ->leftJoin('flights', 'crew_normal_flights.flight_id', '=', 'flights.id')
            ->leftJoin('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->leftJoin('jobs', 'crews.job_id', '=', 'jobs.id')
            ->select(
                'crews.financial_number',
                DB::raw('CONCAT(crews.first_name, " ", crews.last_name) as crew_name'),
                'jobs.job_name',
                DB::raw('COUNT(DISTINCT flights.id) as flights_count'),
                DB::raw('COALESCE(SUM(flight_hours.hours), 0) as total_hours')
            )
            ->when($dateFrom, fn ($query) => $query->where('flights.flight_date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->where('flights.flight_date', '<=', $dateTo))
            ->groupBy('crews.id', 'crews.financial_number', 'crews.first_name', 'crews.last_name', 'jobs.job_name')
            ->orderByDesc('total_hours')
            ->limit(10)
            ->get();

        $recentFlights = DB::table('flights')
            ->leftJoin('aircrafts', 'flights.aircraft_id', '=', 'aircrafts.id')
            ->leftJoin('airports as origin', 'flights.origin_airport_id', '=', 'origin.id')
            ->leftJoin('airports as destination', 'flights.destination_airport_id', '=', 'destination.id')
            ->leftJoin('flight_hours', 'flights.id', '=', 'flight_hours.flight_id')
            ->select(
                'flights.flight_number',
                'flights.flight_date',
                'flights.flight_type',
                'flights.status',
                'aircrafts.aircraft_name',
                'origin.airport_name as origin_name',
                'destination.airport_name as destination_name',
                'flight_hours.hours'
            )
            ->when($dateFrom, fn ($query) => $query->where('flights.flight_date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->where('flights.flight_date', '<=', $dateTo))
            ->orderByDesc('flights.flight_date')
            ->limit(15)
            ->get();

        $exports = $this->exportDefinitions();

        return view('employee.reports.index', compact(
            'dateFrom',
            'dateTo',
            'stats',
            'flightStatus',
            'monthlyFlights',
            'topAircraft',
            'topCrew',
            'recentFlights',
            'exports'
        ));
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        $exports = $this->exportDefinitions();
        abort_unless(array_key_exists($type, $exports), 404);

        [$headers, $query] = $this->exportQuery($type, $request);
        $orderColumn = $this->exportOrderColumn($type);
        $filename = $type . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($headers, $query, $orderColumn) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $headers);

            $query->orderBy($orderColumn)->chunk(500, function ($rows) use ($handle, $headers) {
                foreach ($rows as $row) {
                    $data = [];
                    foreach ($headers as $key => $label) {
                        $data[] = $row->{$key} ?? '';
                    }
                    fputcsv($handle, $data);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function exportDefinitions(): array
    {
        return [
            'flights' => 'الرحلات',
            'flight-hours' => 'ساعات الطيران',
            'aircraft' => 'الطائرات',
            'airports' => 'المطارات',
            'crew' => 'الطاقم',
            'jobs' => 'الوظائف',
            'users' => 'المستخدمين',
        ];
    }

    private function exportQuery(string $type, Request $request): array
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        return match ($type) {
            'flights' => [
                [
                    'id' => 'ID',
                    'flight_number' => 'Flight Number',
                    'flight_date' => 'Flight Date',
                    'flight_type' => 'Flight Type',
                    'aircraft_name' => 'Aircraft',
                    'origin_name' => 'Origin',
                    'destination_name' => 'Destination',
                    'departure_time' => 'Departure Time',
                    'arrival_time' => 'Arrival Time',
                    'aircraft_number' => 'Aircraft Number',
                    'status' => 'Status',
                ],
                DB::table('flights')
                    ->leftJoin('aircrafts', 'flights.aircraft_id', '=', 'aircrafts.id')
                    ->leftJoin('airports as origin', 'flights.origin_airport_id', '=', 'origin.id')
                    ->leftJoin('airports as destination', 'flights.destination_airport_id', '=', 'destination.id')
                    ->select('flights.id', 'flights.flight_number', 'flights.flight_date', 'flights.flight_type', 'aircrafts.aircraft_name', 'origin.airport_name as origin_name', 'destination.airport_name as destination_name', 'flights.departure_time', 'flights.arrival_time', 'flights.aircraft_number', 'flights.status')
                    ->when($dateFrom, fn ($query) => $query->where('flights.flight_date', '>=', $dateFrom))
                    ->when($dateTo, fn ($query) => $query->where('flights.flight_date', '<=', $dateTo)),
            ],
            'flight-hours' => [
                [
                    'id' => 'ID',
                    'flight_number' => 'Flight Number',
                    'flight_date' => 'Flight Date',
                    'aircraft_name' => 'Aircraft',
                    'hours' => 'Hours',
                ],
                DB::table('flight_hours')
                    ->leftJoin('flights', 'flight_hours.flight_id', '=', 'flights.id')
                    ->leftJoin('aircrafts', 'flight_hours.aircraft_id', '=', 'aircrafts.id')
                    ->select('flight_hours.id', 'flights.flight_number', 'flights.flight_date', 'aircrafts.aircraft_name', 'flight_hours.hours')
                    ->when($dateFrom, fn ($query) => $query->where('flights.flight_date', '>=', $dateFrom))
                    ->when($dateTo, fn ($query) => $query->where('flights.flight_date', '<=', $dateTo)),
            ],
            'aircraft' => [
                [
                    'id' => 'ID',
                    'aircraft_name' => 'Aircraft Name',
                    'aircraft_code' => 'Aircraft Model',
                    'manufacturer' => 'Manufacturer',
                    'registration_number' => 'Registration Number',
                    'status' => 'Status',
                    'created_at' => 'Created At',
                ],
                DB::table('aircrafts')->select('id', 'aircraft_name', 'aircraft_code', 'manufacturer', 'registration_number', 'status', 'created_at'),
            ],
            'airports' => [
                [
                    'id' => 'ID',
                    'airport_name' => 'Airport Name',
                    'airport_code' => 'Airport Code',
                    'created_at' => 'Created At',
                ],
                DB::table('airports')->select('id', 'airport_name', 'airport_code', 'created_at'),
            ],
            'crew' => [
                [
                    'id' => 'ID',
                    'financial_number' => 'Financial Number',
                    'crew_name' => 'Crew Name',
                    'job_name' => 'Job',
                    'license_number' => 'License Number',
                    'aircraft_type' => 'Aircraft Type',
                    'status' => 'Status',
                ],
                DB::table('crews')
                    ->leftJoin('jobs', 'crews.job_id', '=', 'jobs.id')
                    ->select('crews.id', 'crews.financial_number', DB::raw('CONCAT(crews.first_name, " ", crews.last_name) as crew_name'), 'jobs.job_name', 'crews.license_number', 'crews.aircraft_type', 'crews.status'),
            ],
            'jobs' => [
                [
                    'id' => 'ID',
                    'job_name' => 'Job Name',
                    'job_type' => 'Job Type',
                    'status' => 'Status',
                    'hourly_calculation' => 'Hourly Calculation',
                    'created_at' => 'Created At',
                ],
                DB::table('jobs')
                    ->leftJoin('job_types', 'jobs.type_id', '=', 'job_types.id')
                    ->select('jobs.id', 'jobs.job_name', 'job_types.job_type', 'jobs.status', 'jobs.hourly_calculation', 'jobs.created_at'),
            ],
            'users' => [
                [
                    'id' => 'ID',
                    'name' => 'Name',
                    'email' => 'Email',
                    'role' => 'Role',
                    'phone' => 'Phone',
                    'is_active' => 'Active',
                    'created_at' => 'Created At',
                ],
                DB::table('users')->select('id', 'name', 'email', 'role', 'phone', 'is_active', 'created_at'),
            ],
        };
    }

    private function applyDateFilter($query, ?string $dateFrom, ?string $dateTo, string $column): void
    {
        if ($dateFrom) {
            $query->where($column, '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where($column, '<=', $dateTo);
        }
    }
}