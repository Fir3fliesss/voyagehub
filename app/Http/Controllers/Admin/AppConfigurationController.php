<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AppConfigurationController extends Controller
{
    public function index()
    {
        return view('admin.app-configurations.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'items_per_page' => 'required|integer|min:1',
        ]);

        // Update .env file or config values
        // For simplicity, we'll just update config values directly for now
        // In a real application, you might want to use a dedicated settings table or a package
        config(['app.name' => $request->input('app_name')]);
        config(['app.items_per_page' => $request->input('items_per_page')]);

        // Optionally, clear config cache if you're writing to .env and then reading it
        // Artisan::call('config:clear');

        return redirect()->back()->with('success', 'App configurations updated successfully!');
    }
}