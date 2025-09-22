<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripApprovalController extends Controller
{
    public function index()
    {
        $trips = Trip::where('status', 'pending')->with(['user', 'journey'])->get();
        return view('admin.trip_approvals.index', compact('trips'));
    }

    public function approve(Trip $trip)
    {
        $trip->status = 'approved';
        $trip->save();
        return redirect()->route('admin.trip_approvals.index')->with('success', 'Perjalanan berhasil disetujui.');
    }

    public function reject(Trip $trip)
    {
        $trip->status = 'rejected';
        $trip->save();
        return redirect()->route('admin.trip_approvals.index')->with('error', 'Perjalanan berhasil ditolak.');
    }
}
