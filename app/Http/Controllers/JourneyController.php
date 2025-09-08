<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Journey;
use App\Services\DashboardService;

class JourneyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = DashboardService::getUserDashboardStats($user);

        return view('user.dashboard', $stats);
    }


    public function create()
    {
        return view('user.newtrip');
    }

    public function store(Request $request)
    {
        // 
        $request->validate([
            'title'       => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'transport'   => 'nullable|string|max:255',
            'accommodation' => 'nullable|string|max:255',
            'budget'      => 'nullable|numeric|min:0',
            'notes'       => 'nullable|string',
        ]);

        Journey::create([
            'user_id'      => Auth::id(),
            'title'        => $request->title,
            'destination'  => $request->destination,
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
            'transport'    => $request->transport,
            'accommodation' => $request->accommodation,
            'budget'       => $request->budget,
            'notes'        => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Perjalanan baru berhasil ditambahkan!');
    }
}
