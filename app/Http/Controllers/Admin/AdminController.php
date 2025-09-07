<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalTrips = \App\Models\Journey::count();
        $upcomingTrips = \App\Models\Journey::whereDate('start_date', '>=', now())->count();

        return view('admin.dashboard', compact('totalUsers', 'totalTrips', 'upcomingTrips'));
    }
}
