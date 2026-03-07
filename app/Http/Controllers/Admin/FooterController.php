<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterController extends Controller
{
    public function index()
    {
        $sections = FooterSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/Footer/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate(['data' => ['required', 'array']]);

        FooterSection::updateOrCreate(
            ['section' => $section],
            ['data'    => $request->input('data')],
        );

        return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' updated successfully.');
    }
}
