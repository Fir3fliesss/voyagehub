<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
<<<<<<< HEAD
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
=======
    public function index()
    {
        $users = User::latest()->paginate(15);
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
            'nik' => 'required|numeric|unique:users,nik',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $updateData = [
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
>>>>>>> 4b0d94f (feat: implement travel request management system)
}
