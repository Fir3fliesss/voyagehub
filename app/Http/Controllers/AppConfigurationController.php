<?php

namespace App\Http\Controllers;

use App\Models\AppConfiguration;
use App\Models\Organization;
use Illuminate\Http\Request;

class AppConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configurations = AppConfiguration::all();
        return view('admin.app_configurations.index', compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organizations = Organization::all();
        return view('admin.app_configurations.create', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        AppConfiguration::create($request->all());

        return redirect()->route('admin.app-configurations.index')->with('success', 'Konfigurasi aplikasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tidak digunakan untuk resource ini
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppConfiguration $appConfiguration)
    {
        $organizations = Organization::all();
        return view('admin.app_configurations.edit', compact('appConfiguration', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppConfiguration $appConfiguration)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $appConfiguration->update($request->all());

        return redirect()->route('admin.app-configurations.index')->with('success', 'Konfigurasi aplikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppConfiguration $appConfiguration)
    {
        $appConfiguration->delete();

        return redirect()->route('admin.app-configurations.index')->with('success', 'Konfigurasi aplikasi berhasil dihapus.');
    }
}
