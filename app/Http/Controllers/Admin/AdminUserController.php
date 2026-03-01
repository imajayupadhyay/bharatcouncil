<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return Inertia::render('Admin/AdminUsers', [
            'admin'   => Auth::guard('admin')->user(),
            'users'   => $users,
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/AdminUserForm', [
            'admin' => Auth::guard('admin')->user(),
            'user'  => null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admin-users')->with('success', 'Admin user created successfully.');
    }

    public function edit(Admin $adminUser)
    {
        return Inertia::render('Admin/AdminUserForm', [
            'admin' => Auth::guard('admin')->user(),
            'user'  => $adminUser->only('id', 'name', 'email', 'created_at'),
        ]);
    }

    public function update(Request $request, Admin $adminUser)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:admins,email,' . $adminUser->id],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable'],
        ]);

        $adminUser->name  = $request->name;
        $adminUser->email = $request->email;

        if ($request->filled('password')) {
            $adminUser->password = Hash::make($request->password);
        }

        $adminUser->save();

        return redirect()->route('admin.admin-users')->with('success', 'Admin user updated successfully.');
    }

    public function destroy(Admin $adminUser)
    {
        if ($adminUser->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $adminUser->delete();

        return back()->with('success', 'Admin user deleted.');
    }
}
