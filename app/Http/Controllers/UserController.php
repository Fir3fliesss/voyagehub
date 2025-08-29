<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'nik' => $request->nik,
        ]);

        return redirect()->route('settings')->with('success', 'Profile updated successfully.');
    }
}
