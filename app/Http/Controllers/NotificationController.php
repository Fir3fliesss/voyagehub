<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirect based on notification type
        $data = $notification->data;
        if (isset($data['travel_request_id'])) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.travel-requests.show', $data['travel_request_id']);
            } else {
                return redirect()->route('travel-requests.show', $data['travel_request_id']);
            }
        }

        return redirect()->route('notifications.index');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted.');
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();

        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = Auth::user()->notifications()
                                  ->take(5)
                                  ->get()
                                  ->map(function ($notification) {
                                      return [
                                          'id' => $notification->id,
                                          'data' => $notification->data,
                                          'read_at' => $notification->read_at,
                                          'created_at' => $notification->created_at->diffForHumans(),
                                      ];
                                  });

        return response()->json($notifications);
    }
}
