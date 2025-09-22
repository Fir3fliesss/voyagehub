<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subMonths(6);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        // Total Trips and Expenses over time
        $tripsOverTime = Trip::selectRaw('DATE(created_at) as date, count(*) as total_trips, sum(cost) as total_expenses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // User Registration Growth
        $userRegistrations = User::selectRaw('DATE(created_at) as date, count(*) as total_users')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Users by Trips and Expenses
        $topUsers = User::withCount('trips')
            ->withSum('trips', 'cost')
            ->orderByDesc('trips_count')
            ->take(10)
            ->get();

        // Trip Status Distribution
        $tripStatus = Trip::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact('tripsOverTime', 'userRegistrations', 'topUsers', 'tripStatus', 'startDate', 'endDate'));
    }
}