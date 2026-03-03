<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhoWeAreSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WhoWeAreController extends Controller
{
    public function index()
    {
        $sections = WhoWeAreSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/WhoWeAre/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate([
            'data' => ['required', 'array'],
        ]);

        WhoWeAreSection::updateOrCreate(
            ['section' => $section],
            ['data' => $request->input('data')],
        );

        return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' section updated successfully.');
    }
}
