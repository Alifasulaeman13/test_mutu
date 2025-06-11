<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return redirect()->route('master-users.create');
    }

    public function create()
    {
        $users = User::with(['role', 'unit'])->get();
        $roles = Role::all();
        $units = Unit::where('is_active', true)->orderBy('name')->get();
        
        return view('master_users.create', compact('users', 'roles', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'boolean'
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['password'] = Hash::make($validated['password']);

        DB::transaction(function () use ($validated) {
            User::create($validated);
        });

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'boolean'
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active');

        DB::transaction(function () use ($user, $validated) {
            $user->update($validated);
        });

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui'
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    public function show(User $user)
    {
        return response()->json($user->load(['role', 'unit']));
    }
} 