<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // =========================
    // LIST USERS
    // =========================
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        return view('users.create');
    }

    // =========================
    // STORE USER
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // =========================
    // UPDATE USER
    // =========================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('password123')
        ]);

        return back()->with('success', 'Password reset successfully');
    }
}