<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Flight;
use App\Models\FlightHour;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        $accountStats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'employees' => User::where('role', 'employee')->count(),
            'captains' => User::where('role', 'captain')->count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        $flightStats = [
            'total' => Flight::count(),
            'this_month' => Flight::whereMonth('flight_date', $month)
                ->whereYear('flight_date', $year)->count(),
            'total_hours' => round(FlightHour::sum('hours') ?? 0, 1),
            'month_hours' => round(
                FlightHour::whereHas('flight', function ($q) use ($month, $year) {
                    $q->whereMonth('flight_date', $month)->whereYear('flight_date', $year);
                })->sum('hours') ?? 0, 1),
        ];

        $accountTrend = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $now->copy()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();

        $trendLabels = $accountTrend->map(fn($r) =>
            Carbon::create($r->year, $r->month)->translatedFormat('M Y')
        )->toArray();
        $trendCounts = $accountTrend->pluck('count')->toArray();

        $roleLabels = ['موظف', 'كابتن', 'مدير'];
        $roleCounts = [
            $accountStats['employees'],
            $accountStats['captains'],
            $accountStats['admins'],
        ];

        $recentAccounts = User::latest()->take(8)->get();

        $topCaptains = FlightHour::select(
            'flight_id',
            DB::raw('SUM(hours) as total_hours'),
            DB::raw('COUNT(*) as total_flights')
        )
            ->whereHas('flight', function ($q) {
                $q->whereNotNull('flight_id');
            })
            ->with('flight:id,flight_number')
            ->groupBy('flight_id')
            ->orderByDesc('total_hours')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'accountStats',
            'flightStats',
            'trendLabels',
            'trendCounts',
            'roleLabels',
            'roleCounts',
            'recentAccounts',
            'topCaptains',
        ));
    }
}