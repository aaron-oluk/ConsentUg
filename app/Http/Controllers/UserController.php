<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', Rule::in($this->assignableRoles())],
            'is_active' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('users')->with('success', 'User created successfully');
    }

    public function update(Request $request, User $user)
    {
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot edit a super admin account');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Update your own password in Settings');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->assignableRoles())],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_active = $request->boolean('is_active');

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('users')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot delete a super admin account');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }

    /**
     * @return array<int, string>
     */
    private function assignableRoles(): array
    {
        $roles = ['user', 'editor', 'admin'];

        if (auth()->user()->isSuperAdmin()) {
            $roles[] = 'super_admin';
        }

        return $roles;
    }
}
