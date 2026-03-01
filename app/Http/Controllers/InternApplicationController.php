<?php

namespace App\Http\Controllers;

use App\Models\InternApplication;
use Illuminate\Http\Request;

class InternApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => 'required|string|max:50',
            'city'               => 'required|string|max:255',
            'institution'        => 'required|string|max:255',
            'programme'          => 'required|string|max:255',
            'discipline'         => 'required|string|max:255',
            'grad_year'          => 'required|string|max:20',
            'track'              => 'required|string|max:255',
            'cohort'             => 'required|string|max:255',
            'mode'               => 'required|string|max:255',
            'duration'           => 'required|string|max:255',
            'statement'          => 'required|string',
            'governance_problem' => 'nullable|string',
        ]);

        InternApplication::create($validated);

        return response()->json(['success' => true, 'message' => 'Your internship application has been submitted successfully.']);
    }
}
