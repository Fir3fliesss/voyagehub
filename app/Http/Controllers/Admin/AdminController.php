<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journey;
use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalJourneys = Journey::count();
        $totalRequests = TravelRequest::count();
        $pendingRequests = TravelRequest::where('status', 'pending')->count();
        $approvedRequests = TravelRequest::where('status', 'approved')->count();
        $totalBudget = Journey::sum('budget');

        // SQLite compatible month/year filtering
        $currentMonth = now()->format('Y-m');
        $thisMonthJourneys = Journey::whereRaw("strftime('%Y-%m', created_at) = ?", [$currentMonth])
                                  ->count();

        // Chart Data for Last 12 Months
        $monthlyData = $this->getMonthlyJourneyData();
        $budgetAnalysis = $this->getBudgetAnalysisData();
        $statusDistribution = $this->getStatusDistributionData();
        $topDestinations = $this->getTopDestinationsData();

        $stats = [
            'total_users' => $totalUsers,
            'total_journeys' => $totalJourneys,
            'total_requests' => $totalRequests,
            'pending_requests' => $pendingRequests,
            'approved_requests' => $approvedRequests,
            'rejected_requests' => $totalRequests - $pendingRequests - $approvedRequests,
            'total_budget' => $totalBudget,
            'this_month_journeys' => $thisMonthJourneys,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'monthlyData',
            'budgetAnalysis',
            'statusDistribution',
            'topDestinations'
        ));
    }

    private function getMonthlyJourneyData()
    {
        // Check database driver for compatibility
        $driver = config('database.default');
        $connection = config("database.connections.{$driver}.driver");

        if ($connection === 'sqlite') {
            // SQLite compatible query
            $monthlyJourneys = Journey::select(
                DB::raw("CAST(strftime('%Y', start_date) AS INTEGER) as year"),
                DB::raw("CAST(strftime('%m', start_date) AS INTEGER) as month"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(budget) as budget')
            )
            ->where('start_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        } else {
            // MySQL compatible query
            $monthlyJourneys = Journey::select(
                DB::raw('YEAR(start_date) as year'),
                DB::raw('MONTH(start_date) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(budget) as budget')
            )
            ->where('start_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        }

        $labels = [];
        $journeyData = [];
        $budgetData = [];

        // Generate last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;

            $monthData = $monthlyJourneys->where('year', $date->year)
                                       ->where('month', $date->month)
                                       ->first();

            $journeyData[] = $monthData ? $monthData->total : 0;
            $budgetData[] = $monthData ? $monthData->budget : 0;
        }

        return [
            'labels' => $labels,
            'journeys' => $journeyData,
            'budget' => $budgetData
        ];
    }

    private function getBudgetAnalysisData()
    {
        $budgetByUser = Journey::select('users.name', DB::raw('SUM(budget) as total_budget'))
                              ->join('users', 'journeys.user_id', '=', 'users.id')
                              ->where('journeys.start_date', '>=', now()->startOfYear())
                              ->groupBy('users.id', 'users.name')
                              ->orderBy('total_budget', 'desc')
                              ->limit(10)
                              ->get();

        return [
            'labels' => $budgetByUser->pluck('name')->toArray(),
            'data' => $budgetByUser->pluck('total_budget')->toArray()
        ];
    }

    private function getStatusDistributionData()
    {
        $statusCounts = TravelRequest::select('status', DB::raw('COUNT(*) as count'))
                                   ->groupBy('status')
                                   ->get();

        $labels = [];
        $data = [];
        $colors = [
            'pending' => '#ffc107',
            'approved' => '#28a745',
            'rejected' => '#dc3545'
        ];
        $backgroundColors = [];

        foreach ($statusCounts as $status) {
            $labels[] = ucfirst($status->status);
            $data[] = $status->count;
            $backgroundColors[] = $colors[$status->status] ?? '#6c757d';
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $backgroundColors
        ];
    }

    private function getTopDestinationsData()
    {
        $destinations = Journey::select('destination', DB::raw('COUNT(*) as total'))
                              ->where('start_date', '>=', now()->startOfYear())
                              ->groupBy('destination')
                              ->orderBy('total', 'desc')
                              ->limit(8)
                              ->get();

        return [
            'labels' => $destinations->pluck('destination')->toArray(),
            'data' => $destinations->pluck('total')->toArray()
        ];
    }

    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'monthly');

        switch ($type) {
            case 'monthly':
                return response()->json($this->getMonthlyJourneyData());
            case 'budget':
                return response()->json($this->getBudgetAnalysisData());
            case 'status':
                return response()->json($this->getStatusDistributionData());
            case 'destinations':
                return response()->json($this->getTopDestinationsData());
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }
}
