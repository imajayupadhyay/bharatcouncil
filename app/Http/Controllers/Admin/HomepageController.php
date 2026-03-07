<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function uploadVoiceImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:3072'],
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $voicesSection = HomepageSection::where('section', 'voices')->first();
        $data   = $voicesSection?->data ?? [];
        $voices = $data['voices'] ?? [];

        // Delete old image if it was a stored upload
        if (!empty($voices[$index]['stored_path'])) {
            Storage::disk('public')->delete($voices[$index]['stored_path']);
        }

        $path = $request->file('image')->store('homepage/voices', 'public');
        $url  = '/storage/' . $path;

        if (isset($voices[$index])) {
            $voices[$index]['image']       = $url;
            $voices[$index]['stored_path'] = $path;
        }

        $data['voices'] = $voices;

        HomepageSection::updateOrCreate(
            ['section' => 'voices'],
            ['data'    => $data],
        );

        return back()->with('success', 'Voice photo updated successfully.');
    }

    public function removeVoiceImage(Request $request)
    {
        $request->validate([
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $voicesSection = HomepageSection::where('section', 'voices')->first();
        $data   = $voicesSection?->data ?? [];
        $voices = $data['voices'] ?? [];

        if (isset($voices[$index]) && !empty($voices[$index]['stored_path'])) {
            Storage::disk('public')->delete($voices[$index]['stored_path']);
        }

        if (isset($voices[$index])) {
            $voices[$index]['image']       = null;
            $voices[$index]['stored_path'] = null;
        }

        $data['voices'] = $voices;

        HomepageSection::updateOrCreate(
            ['section' => 'voices'],
            ['data'    => $data],
        );

        return back()->with('success', 'Voice photo removed.');
    }
}
