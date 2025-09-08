<?php

namespace App\Services;

use App\Models\Journey;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardService
{
    public static function getUserDashboardStats($user)
    {
        $totalTrips = $user->journeys()->count();
        $totalExpenses = $user->journeys()->sum('budget');
        $activeTrips = $user->journeys()
            ->whereDate('end_date', '>=', now())
            ->count();
        $countriesVisited = $user->journeys()
            ->select('destination')
            ->distinct()
            ->count();
        $recentActivities = $user->journeys()
            ->latest()
            ->take(5)
            ->get();

        return compact('totalTrips', 'totalExpenses', 'activeTrips', 'countriesVisited', 'recentActivities');
    }

    public static function getAdminDashboardStats(Request $request)
     {
         if (!$request instanceof Request) {
             // Handle the case where $request is not an instance of Request
             // For example, log an error or throw an exception
             // For now, we'll return empty stats or default values
             return [
                 'totalUsers' => 0,
                 'totalTrips' => 0,
                 'totalExpenses' => 0,
                 'recentActivities' => collect(),
             ];
         }

         $totalUsers = User::count();
        $totalTrips = Journey::count();
        $totalExpenses = Journey::sum('budget');

        $query = Journey::with('user');

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('location', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $recentActivities = $query->latest()->paginate(5);

        return compact('totalUsers', 'totalTrips', 'totalExpenses', 'recentActivities');
    }
}
