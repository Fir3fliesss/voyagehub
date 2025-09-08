<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index()
{
$users = User::paginate(10);
return view('admin.users.index', compact('users'));
}

public function create()
{
return view('admin.users.create');
}

public function store(Request $request)
{
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|string|email|unique:users',
'password' => 'required|string|min:6|confirmed',
'role' => 'required|in:admin,client',
]);

User::create([
'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password),
'role' => $request->role,
]);

return redirect()->route('users.index')->with('success', 'User created successfully.');
}

public function edit(User $user)
{
return view('admin.users.edit', compact('user'));
}

public function update(Request $request, User $user)
{
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|string|email|unique:users,email,' . $user->id,
'nik' => 'required|string|max:255|unique:users,nik,' . $user->id,
'role' => 'required|in:admin,client',
]);

$user->update([
'name' => $request->name,
'email' => $request->email,
'nik' => $request->nik,
'role' => $request->role,
]);

if ($request->filled('password')) {
$request->validate(['password' => 'string|min:6|confirmed']);
$user->update(['password' => Hash::make($request->password)]);
}

return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

public function destroy(User $user)
{
if ($user->id === auth()->user()->id) {
return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
}

$user->delete();
return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}
}
