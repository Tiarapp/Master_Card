<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'divisi', 'company'])->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function assignRole(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        return view('admin.users.assign-role', compact('user', 'roles', 'userRoleIds'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('users.index')
            ->with('success', 'Role untuk user "' . $user->name . '" berhasil diperbarui.');
    }
}
