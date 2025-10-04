<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelRequestController extends Controller
{
    public function index()
    {
        $travelRequests = TravelRequest::where('user_id', Auth::id())
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(10);

        return view('user.travel_requests.index', compact('travelRequests'));
    }

    public function create()
    {
        return view('user.travel_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $travelRequest = TravelRequest::create([
            'user_id' => Auth::id(),
            'purpose' => $request->purpose,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Notify all admins about new travel request
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\TravelRequestNotification($travelRequest, 'submitted'));
        }

        return redirect()->route('travel-requests.index')
                        ->with('success', 'Travel request submitted successfully. Waiting for approval.');
    }

    public function show(TravelRequest $travelRequest)
    {
        // Ensure user can only view their own requests
        if ($travelRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $travelRequest->load(['approver']);
        return view('user.travel_requests.show', compact('travelRequest'));
    }

    public function edit(TravelRequest $travelRequest)
    {
        // Ensure user can only edit their own pending requests
        if ($travelRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($travelRequest->status !== 'pending') {
            return redirect()->route('travel-requests.index')
                           ->withErrors(['status' => 'Only pending requests can be edited.']);
        }

        return view('user.travel_requests.edit', compact('travelRequest'));
    }

    public function update(Request $request, TravelRequest $travelRequest)
    {
        // Ensure user can only update their own pending requests
        if ($travelRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($travelRequest->status !== 'pending') {
            return redirect()->route('travel-requests.index')
                           ->withErrors(['status' => 'Only pending requests can be edited.']);
        }

        $request->validate([
            'purpose' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $travelRequest->update([
            'purpose' => $request->purpose,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'notes' => $request->notes,
        ]);

        return redirect()->route('travel-requests.index')
                        ->with('success', 'Travel request updated successfully.');
    }

    public function destroy(TravelRequest $travelRequest)
    {
        // Ensure user can only delete their own pending requests
        if ($travelRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($travelRequest->status !== 'pending') {
            return redirect()->route('travel-requests.index')
                           ->withErrors(['status' => 'Only pending requests can be deleted.']);
        }

        $travelRequest->delete();

        return redirect()->route('travel-requests.index')
                        ->with('success', 'Travel request deleted successfully.');
    }
}