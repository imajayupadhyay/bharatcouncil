<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkWithUsSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkWithUsController extends Controller
{
    public function index()
    {
        $sections = WorkWithUsSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/WorkWithUs/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate([
            'data' => ['required', 'array'],
        ]);

        WorkWithUsSection::updateOrCreate(
            ['section' => $section],
            ['data' => $request->input('data')],
        );

        return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' section updated successfully.');
    }
}
