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
            'cv_file'             => 'nullable|file|mimes:pdf,doc,docx|max:3072',
            'sample_file'         => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'extra_file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'referees'            => 'nullable|string',
            'additional_notes'    => 'nullable|string',
        ]);

        $data = collect($validated)->except(['cv_file', 'sample_file', 'extra_file'])->toArray();

        if ($request->hasFile('cv_file')) {
            $data['cv_path'] = $request->file('cv_file')->store('applications/cv', 'public');
        }
        if ($request->hasFile('sample_file')) {
            $data['sample_path'] = $request->file('sample_file')->store('applications/samples', 'public');
        }
        if ($request->hasFile('extra_file')) {
            $data['extra_path'] = $request->file('extra_file')->store('applications/extra', 'public');
        }

        MemberApplication::create($data);

        return response()->json(['success' => true, 'message' => 'Your application has been submitted successfully.']);
    }
}
