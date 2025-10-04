<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = TravelRequest::with(['user', 'approver']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date !== '') {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Search by purpose or destination
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('purpose', 'like', '%' . $request->search . '%')
                  ->orWhere('destination', 'like', '%' . $request->search . '%');
            });
        }

        $travelRequests = $query->orderBy('created_at', 'desc')->paginate(15);
        $users = User::where('role', 'user')->get();

        return view('admin.travel_requests.index', compact('travelRequests', 'users'));
    }

    public function show(TravelRequest $travelRequest)
    {
        $travelRequest->load(['user', 'approver']);
        return view('admin.travel_requests.show', compact('travelRequest'));
    }

    public function approve(Request $request, TravelRequest $travelRequest)
    {
        if ($travelRequest->status !== 'pending') {
            return back()->withErrors(['status' => 'Only pending requests can be approved.']);
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $travelRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes ?? $travelRequest->notes,
        ]);

        // Notify user about approval
        $travelRequest->user->notify(new \App\Notifications\TravelRequestNotification($travelRequest, 'approved', Auth::user()));

        return redirect()->route('admin.travel-requests.index')
                        ->with('success', 'Travel request approved successfully.');
    }

    public function reject(Request $request, TravelRequest $travelRequest)
    {
        if ($travelRequest->status !== 'pending') {
            return back()->withErrors(['status' => 'Only pending requests can be rejected.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $travelRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->rejection_reason,
        ]);

        // Notify user about rejection
        $travelRequest->user->notify(new \App\Notifications\TravelRequestNotification($travelRequest, 'rejected', Auth::user()));

        return redirect()->route('admin.travel-requests.index')
                        ->with('success', 'Travel request rejected.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'request_ids' => 'required|array',
            'request_ids.*' => 'exists:travel_requests,id',
            'bulk_notes' => 'nullable|string|max:500',
        ]);

        $requests = TravelRequest::whereIn('id', $request->request_ids)->get();

        foreach ($requests as $travelRequest) {
            switch ($request->action) {
                case 'approve':
                    if ($travelRequest->status === 'pending') {
                        $travelRequest->update([
                            'status' => 'approved',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'notes' => $request->bulk_notes ?? $travelRequest->notes,
                        ]);
                    }
                    break;

                case 'reject':
                    if ($travelRequest->status === 'pending') {
                        $travelRequest->update([
                            'status' => 'rejected',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'notes' => $request->bulk_notes ?? $travelRequest->notes,
                        ]);
                    }
                    break;

                case 'delete':
                    $travelRequest->delete();
                    break;
            }
        }

        $message = match($request->action) {
            'approve' => 'Selected requests approved successfully.',
            'reject' => 'Selected requests rejected successfully.',
            'delete' => 'Selected requests deleted successfully.',
        };

        return redirect()->route('admin.travel-requests.index')->with('success', $message);
    }
}