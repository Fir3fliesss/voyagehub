<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Journey;
<<<<<<< HEAD
use App\Services\DashboardService;
=======
use App\Models\TravelRequest;
>>>>>>> 4b0d94f (feat: implement travel request management system)

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
        // Ambil travel request yang sudah di-approve milik user
        $approvedRequests = TravelRequest::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->whereDoesntHave('journey') // Pastikan belum ada journey untuk request ini
            ->get();

        // Jika tidak ada request yang approved, redirect dengan pesan
        if ($approvedRequests->isEmpty()) {
            return redirect()->route('dashboard')
                ->with('warning', 'Anda belum memiliki travel request yang disetujui. Silakan buat travel request terlebih dahulu.');
        }

        return view('user.newtrip', compact('approvedRequests'));
    }

    public function store(Request $request)
    {
        // 
        $request->validate([
            'travel_request_id' => 'required|exists:travel_requests,id',
            'transport'   => 'nullable|string|max:255',
            'accommodation' => 'nullable|string|max:255',
            'budget'      => 'nullable|numeric|min:0',
            'notes'       => 'nullable|string',
        ]);

        // Ambil travel request yang dipilih
        $travelRequest = TravelRequest::findOrFail($request->travel_request_id);

        // Pastikan travel request milik user yang sedang login dan statusnya approved
        if ($travelRequest->user_id !== Auth::id() || $travelRequest->status !== 'approved') {
            return redirect()->back()->with('error', 'Travel request tidak valid atau belum disetujui.');
        }

        // Pastikan belum ada journey untuk travel request ini
        if ($travelRequest->journey) {
            return redirect()->back()->with('error', 'Trip untuk travel request ini sudah pernah dibuat.');
        }

        Journey::create([
            'user_id'         => Auth::id(),
            'travel_request_id' => $request->travel_request_id,
            'title'           => $travelRequest->purpose, // Gunakan purpose dari travel request
            'destination'     => $travelRequest->destination,
            'start_date'      => $travelRequest->start_date,
            'end_date'        => $travelRequest->end_date,
            'transport'       => $request->transport,
            'accommodation'   => $request->accommodation,
            'budget'          => $request->budget ?? $travelRequest->budget,
            'notes'           => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Trip berhasil ditambahkan berdasarkan travel request yang disetujui!');
    }
}
