<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomepageController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/Homepage/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate([
            'data' => ['required', 'array'],
        ]);

        HomepageSection::updateOrCreate(
            ['section' => $section],
            ['data' => $request->input('data')],
        );

        return back()->with('success', ucfirst($section) . ' section updated successfully.');
    }
}
