<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        $roles = ['admin', 'petugas', 'peminjam'];
        return view('management.users', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', __('User account created successfully!'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        if (isset($validated['password']) && !empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', __('User account updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            return redirect()->route('admin.users.index')->with('error', __('You cannot delete your own account!'));
        }

        // Prevent deleting users who have active borrowings
        if ($user->borrowings()->where('status', 'borrowed')->exists()) {
            return redirect()->route('admin.users.index')->with('error', __('Cannot delete this user because they have active borrowings!'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('User account deleted successfully!'));
    }
}
