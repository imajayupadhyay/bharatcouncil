<?php

namespace App\Http\Controllers;

use App\Models\MemberApplication;
use Illuminate\Http\Request;

class MemberApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'           => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'phone'               => 'required|string|max:50',
            'city'                => 'required|string|max:255',
            'designation'         => 'required|string|max:255',
            'organisation'        => 'nullable|string|max:255',
            'membership_type'     => 'required|string|max:255',
            'mode'                => 'required|string|max:255',
            'background'          => 'required|string',
            'contribution_area'   => 'required|string|max:255',
            'board_relation'      => 'nullable|string|max:255',
            'answer_governance'   => 'nullable|string',
            'answer_contribution' => 'nullable|string',
            'answer_reform'       => 'nullable|string',
            'answer_bgc'          => 'nullable|string',
            'referees'            => 'nullable|string',
            'additional_notes'    => 'nullable|string',
        ]);

        MemberApplication::create($validated);

        return response()->json(['success' => true, 'message' => 'Your application has been submitted successfully.']);
    }
}
