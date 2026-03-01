<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberApplication::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Applications', [
            'admin'        => Auth::guard('admin')->user(),
            'applications' => $applications,
            'filters'      => $request->only('status'),
        ]);
    }

    public function show(MemberApplication $application)
    {
        return Inertia::render('Admin/ApplicationShow', [
            'admin'       => Auth::guard('admin')->user(),
            'application' => $application,
        ]);
    }

    public function updateStatus(Request $request, MemberApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return back();
    }
}
