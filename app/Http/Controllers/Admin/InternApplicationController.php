<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InternApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = InternApplication::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/InternApplications', [
            'admin'        => Auth::guard('admin')->user(),
            'applications' => $applications,
            'filters'      => $request->only('status'),
        ]);
    }

    public function show(InternApplication $internApplication)
    {
        return Inertia::render('Admin/InternApplicationShow', [
            'admin'       => Auth::guard('admin')->user(),
            'application' => $internApplication,
        ]);
    }

    public function updateStatus(Request $request, InternApplication $internApplication)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
        ]);

        $internApplication->update(['status' => $request->status]);

        return back();
    }
}
