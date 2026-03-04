<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoverningBoardSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GoverningBoardController extends Controller
{
    public function index()
    {
        $sections = GoverningBoardSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/GoverningBoard/Index', [
            'admin' => Auth::guard('admin')->user(),
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate([
            'data' => ['required', 'array'],
        ]);

        GoverningBoardSection::updateOrCreate(
            ['section' => $section],
            ['data' => $request->input('data')],
        );

        return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' section updated successfully.');
    }
}
