<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
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
=======
use App\Models\Journey;
use App\Models\TravelRequest;
use App\Models\User;
use App\Models\ReportTemplate;
use App\Exports\JourneysExport;
use App\Exports\TravelRequestsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $reportTemplates = ReportTemplate::where('organization_id', 1)->get();

        // Statistics for reports
        $stats = [
            'total_journeys' => Journey::count(),
            'total_requests' => TravelRequest::count(),
            'pending_requests' => TravelRequest::where('status', 'pending')->count(),
            'approved_requests' => TravelRequest::where('status', 'approved')->count(),
            'total_budget' => Journey::sum('budget'),
            'this_month_journeys' => Journey::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.reports.index', compact('users', 'reportTemplates', 'stats'));
    }

    public function exportJourneys(Request $request)
    {
        $request->validate([
            'format' => 'required|in:excel,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'destination' => 'nullable|string',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
            'destination' => $request->destination,
        ];

        // Check if data exists for the filters
        $query = Journey::query()->with('user');

        if ($filters['start_date']) {
            $query->where('start_date', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->where('end_date', '<=', $filters['end_date']);
        }
        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }
        if ($filters['destination']) {
            $query->where('destination', 'like', '%' . $filters['destination'] . '%');
        }

        $journeys = $query->get();

        if ($journeys->isEmpty()) {
            return back()->withErrors(['export' => 'No data found for the selected filters.']);
        }

        $filename = 'journeys_export_' . now()->format('Y-m-d_H-i-s');

        if ($request->format === 'excel') {
            return Excel::download(new JourneysExport($filters), $filename . '.xlsx');
        } else {
            // PDF export
            $pdf = Pdf::loadView('admin.reports.journeys_pdf', compact('journeys', 'filters'));
            return $pdf->download($filename . '.pdf');
        }
    }

    public function exportTravelRequests(Request $request)
    {
        $request->validate([
            'format' => 'required|in:excel,pdf',
            'status' => 'nullable|in:pending,approved,rejected',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $filters = [
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
        ];

        // Check if data exists for the filters
        $query = TravelRequest::query()->with(['user', 'approver']);

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        if ($filters['start_date']) {
            $query->where('start_date', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->where('end_date', '<=', $filters['end_date']);
        }
        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        $requests = $query->get();

        if ($requests->isEmpty()) {
            return back()->withErrors(['export' => 'No data found for the selected filters.']);
        }

        $filename = 'travel_requests_export_' . now()->format('Y-m-d_H-i-s');

        if ($request->format === 'excel') {
            return Excel::download(new TravelRequestsExport($filters), $filename . '.xlsx');
        } else {
            // PDF export
            $travelRequests = $requests; // Alias for consistency with view
            $pdf = Pdf::loadView('admin.reports.travel_requests_pdf', compact('travelRequests', 'filters'));
            return $pdf->download($filename . '.pdf');
        }
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:summary,detailed,budget_analysis',
            'period' => 'required|in:this_month,last_month,this_year,custom',
            'start_date' => 'required_if:period,custom|nullable|date',
            'end_date' => 'required_if:period,custom|nullable|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf',
        ]);

        // Determine date range based on period
        switch ($request->period) {
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                break;
        }

        $data = $this->getReportData($request->report_type, $startDate, $endDate);

        if (empty($data['journeys']) && empty($data['requests'])) {
            return back()->withErrors(['report' => 'No data found for the selected period.']);
        }

        $filename = $request->report_type . '_report_' . now()->format('Y-m-d_H-i-s');

        if ($request->format === 'excel') {
            // Generate Excel report based on type
            return $this->generateExcelReport($request->report_type, $data, $filename);
        } else {
            // Generate PDF report
            $pdf = Pdf::loadView('admin.reports.general_pdf', [
                'reportType' => $request->report_type,
                'period' => $request->period,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'data' => $data
            ]);
            return $pdf->download($filename . '.pdf');
        }
    }

    private function getReportData($reportType, $startDate, $endDate)
    {
        $data = [];

        switch ($reportType) {
            case 'summary':
                $data['journeys'] = Journey::with('user')
                    ->whereBetween('start_date', [$startDate, $endDate])
                    ->get();
                $data['requests'] = TravelRequest::with(['user', 'approver'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
                $data['stats'] = [
                    'total_journeys' => $data['journeys']->count(),
                    'total_budget' => $data['journeys']->sum('budget'),
                    'pending_requests' => $data['requests']->where('status', 'pending')->count(),
                    'approved_requests' => $data['requests']->where('status', 'approved')->count(),
                    'rejected_requests' => $data['requests']->where('status', 'rejected')->count(),
                ];
                break;

            case 'detailed':
                $data['journeys'] = Journey::with('user')
                    ->whereBetween('start_date', [$startDate, $endDate])
                    ->orderBy('start_date', 'desc')
                    ->get();
                $data['requests'] = TravelRequest::with(['user', 'approver'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;

            case 'budget_analysis':
                $data['journeys'] = Journey::with('user')
                    ->whereBetween('start_date', [$startDate, $endDate])
                    ->get();
                $data['budget_by_user'] = $data['journeys']->groupBy('user.name')
                    ->map(function ($journeys) {
                        return [
                            'total_budget' => $journeys->sum('budget'),
                            'trip_count' => $journeys->count(),
                            'avg_budget' => $journeys->avg('budget'),
                        ];
                    });
                $data['budget_by_destination'] = $data['journeys']->groupBy('destination')
                    ->map(function ($journeys) {
                        return [
                            'total_budget' => $journeys->sum('budget'),
                            'trip_count' => $journeys->count(),
                        ];
                    });
                break;
        }

        return $data;
    }

    public function generateFromTemplate(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:report_templates,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $template = ReportTemplate::findOrFail($request->template_id);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
        ];

        $filename = str_replace(' ', '_', strtolower($template->name)) . '_' . now()->format('Y-m-d_H-i-s');

        if ($template->type === 'excel') {
            if (str_contains($template->template_path, 'journeys')) {
                return Excel::download(new JourneysExport($filters), $filename . '.xlsx');
            } else {
                return Excel::download(new TravelRequestsExport($filters), $filename . '.xlsx');
            }
        } else {
            // Generate PDF using template
            if (str_contains($template->template_path, 'general')) {
                // Use advanced report generation
                $data = $this->getReportData('summary',
                    $request->start_date ?: now()->startOfMonth(),
                    $request->end_date ?: now()->endOfMonth()
                );
                $pdf = Pdf::loadView($template->template_path, [
                    'title' => $template->name,
                    'reportType' => 'summary',
                    'data' => $data,
                    'filters' => $filters
                ]);
            } elseif (str_contains($template->template_path, 'journeys')) {
                $journeys = $this->getFilteredJourneys($filters);
                $pdf = Pdf::loadView($template->template_path, compact('journeys', 'filters'));
            } else {
                $requests = $this->getFilteredTravelRequests($filters);
                $travelRequests = $requests;
                $pdf = Pdf::loadView($template->template_path, compact('travelRequests', 'filters'));
            }

            return $pdf->download($filename . '.pdf');
        }
    }

    private function getFilteredJourneys($filters)
    {
        $query = Journey::query()->with('user');

        if ($filters['start_date']) {
            $query->where('start_date', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->where('end_date', '<=', $filters['end_date']);
        }
        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderBy('start_date', 'desc')->get();
    }

    private function getFilteredTravelRequests($filters)
    {
        $query = TravelRequest::query()->with(['user', 'approver']);

        if ($filters['start_date']) {
            $query->where('start_date', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->where('end_date', '<=', $filters['end_date']);
        }
        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    private function generateExcelReport($reportType, $data, $filename)
    {
        // For now, use the existing exports
        // In the future, this could be extended to create custom Excel reports
        if (!empty($data['journeys'])) {
            return Excel::download(new JourneysExport([]), $filename . '.xlsx');
        } elseif (!empty($data['requests'])) {
            return Excel::download(new TravelRequestsExport([]), $filename . '.xlsx');
        }

        return back()->withErrors(['report' => 'Unable to generate Excel report.']);
>>>>>>> 4b0d94f (feat: implement travel request management system)
    }
}