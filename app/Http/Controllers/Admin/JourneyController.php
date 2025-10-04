<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JourneyController extends Controller
{
    public function index(Request $request)
    {
        $query = Journey::with('user');

        // Search by user name or journey title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Filter by budget range
        if ($request->filled('min_budget')) {
            $query->where('budget', '>=', $request->min_budget);
        }

        if ($request->filled('max_budget')) {
            $query->where('budget', '<=', $request->max_budget);
        }

        // Order by latest
        $journeys = $query->latest()->paginate(15);

        // Statistics for dashboard cards
        $totalJourneys = Journey::count();
        $totalBudget = Journey::sum('budget');

        // Handle active journeys with proper date parsing
        $activeJourneys = Journey::all()->filter(function($journey) {
            $now = now();
            $startDate = $journey->start_date instanceof \Carbon\Carbon
                ? $journey->start_date
                : \Carbon\Carbon::parse($journey->start_date);
            $endDate = $journey->end_date
                ? ($journey->end_date instanceof \Carbon\Carbon
                    ? $journey->end_date
                    : \Carbon\Carbon::parse($journey->end_date))
                : null;

            return $startDate <= $now && ($endDate >= $now || !$endDate);
        })->count();

        // Handle upcoming journeys
        $upcomingJourneys = Journey::all()->filter(function($journey) {
            $now = now();
            $startDate = $journey->start_date instanceof \Carbon\Carbon
                ? $journey->start_date
                : \Carbon\Carbon::parse($journey->start_date);

            return $startDate > $now;
        })->count();

        return view('admin.journeys.index', compact(
            'journeys',
            'totalJourneys',
            'totalBudget',
            'activeJourneys',
            'upcomingJourneys'
        ));
    }

    public function show(Journey $journey)
    {
        $journey->load('user');
        return view('admin.journeys.show', compact('journey'));
    }

    public function edit(Journey $journey)
    {
        $users = User::all();
        return view('admin.journeys.edit', compact('journey', 'users'));
    }

    public function update(Request $request, Journey $journey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'transport' => 'nullable|string|max:255',
            'accommodation'=> 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $journey->update($request->all());

        return redirect()->route('admin.journeys.index')->with('success', 'Journey updated successfully.');
    }

    public function destroy(Journey $journey)
    {
        $journey->delete();
        return redirect()->route('admin.journeys.index')->with('success', 'Journey deleted successfully.');
    }
}
