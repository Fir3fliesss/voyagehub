<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
=======
use App\Models\AppConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
>>>>>>> 4b0d94f (feat: implement travel request management system)

class AppConfigurationController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
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
=======
        $configurations = AppConfiguration::where('organization_id', 1)
                                        ->orderBy('key')
                                        ->get()
                                        ->groupBy('key');

        return view('admin.app_configurations.index', compact('configurations'));
    }

    public function create()
    {
        return view('admin.app_configurations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
            'organization_id' => 'required|integer',
        ]);

        // Check for duplicate key within organization
        $existing = AppConfiguration::where('organization_id', $request->organization_id)
                                  ->where('key', $request->key)
                                  ->first();

        if ($existing) {
            return back()->withErrors([
                'key' => 'Configuration key already exists for this organization.'
            ])->withInput();
        }

        AppConfiguration::create([
            'organization_id' => $request->organization_id,
            'key' => $request->key,
            'value' => $request->value,
        ]);

        // Clear cache
        Cache::forget('app_config_' . $request->organization_id);

        return redirect()->route('admin.app-configurations.index')
                        ->with('success', 'Configuration created successfully.');
    }

    public function edit(AppConfiguration $appConfiguration)
    {
        return view('admin.app_configurations.edit', compact('appConfiguration'));
    }

    public function update(Request $request, AppConfiguration $appConfiguration)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
        ]);

        // Check for duplicate key (exclude current record)
        $existing = AppConfiguration::where('organization_id', $appConfiguration->organization_id)
                                  ->where('key', $request->key)
                                  ->where('id', '!=', $appConfiguration->id)
                                  ->first();

        if ($existing) {
            return back()->withErrors([
                'key' => 'Configuration key already exists for this organization.'
            ])->withInput();
        }

        $appConfiguration->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        // Clear cache
        Cache::forget('app_config_' . $appConfiguration->organization_id);

        return redirect()->route('admin.app-configurations.index')
                        ->with('success', 'Configuration updated successfully.');
    }

    public function destroy(AppConfiguration $appConfiguration)
    {
        $organizationId = $appConfiguration->organization_id;
        $appConfiguration->delete();

        // Clear cache
        Cache::forget('app_config_' . $organizationId);

        return redirect()->route('admin.app-configurations.index')
                        ->with('success', 'Configuration deleted successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'configurations' => 'required|array',
            'configurations.*.key' => 'required|string',
            'configurations.*.value' => 'nullable|string',
        ]);

        $organizationId = 1; // Default organization

        foreach ($request->configurations as $config) {
            AppConfiguration::setValue($config['key'], $config['value'], $organizationId);
        }

        // Clear cache
        Cache::forget('app_config_' . $organizationId);

        return redirect()->route('admin.app-configurations.index')
                        ->with('success', 'Configurations updated successfully.');
>>>>>>> 4b0d94f (feat: implement travel request management system)
    }
}