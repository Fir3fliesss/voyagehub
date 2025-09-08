<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Models\User;
use Illuminate\Http\Request;

class TripController extends Controller
{
public function index()
{
// Ambil semua perjalanan dengan user
$trips = Journey::with('user')->latest()->paginate(10);
return view('admin.trips.index', compact('trips'));
}

public function show(Journey $trip)
{
$trip->load('user');
return view('admin.trips.show', compact('trip'));
}

public function edit(Journey $trip)
{
$users = User::all();
return view('admin.trips.edit', compact('trip', 'users'));
}

public function update(Request $request, Journey $trip)
{
$request->validate([
'title' => 'required|string|max:255',
'destination' => 'required|string|max:255',
'start_date' => 'required|date',
'end_date' => 'nullable|date|after_or_equal:start_date',
'transport' => 'nullable|string|max:255',
'accommodation'=> 'nullable|string|max:255',
'budget' => 'nullable|numeric|min:0',
'notes' => 'nullable|string',
'user_id' => 'required|exists:users,id',
]);

$trip->update($request->all());

return redirect()->route('admin.trips.index')->with('success', 'Trip updated successfully.');
}

public function destroy(Journey $trip)
{
$trip->delete();
return redirect()->route('admin.trips.index')->with('success', 'Trip deleted successfully.');
}
}

