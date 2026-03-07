<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HeaderController extends Controller
{
    public function index()
    {
        $sections = HeaderSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/Header/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, string $section)
    {
        $request->validate(['data' => ['required', 'array']]);

        HeaderSection::updateOrCreate(
            ['section' => $section],
            ['data'    => $request->input('data')],
        );

        return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' updated successfully.');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ]);

        // Delete old uploaded logo if it exists
        $existing = HeaderSection::where('section', 'logo')->value('data');
        if (!empty($existing['stored_path'])) {
            Storage::disk('public')->delete($existing['stored_path']);
        }

        $path = $request->file('logo')->store('header', 'public');
        $url  = asset('storage/' . $path);

        HeaderSection::updateOrCreate(
            ['section' => 'logo'],
            ['data'    => ['url' => $url, 'stored_path' => $path]],
        );

        return back()->with('success', 'Logo updated successfully.');
    }
}
