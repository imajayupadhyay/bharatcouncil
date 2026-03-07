<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhoWeAreSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function uploadChairmanPhoto(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $section  = WhoWeAreSection::where('section', 'founding_team')->first();
        $data     = $section?->data ?? [];
        $chairman = $data['chairman'] ?? [];

        if (!empty($chairman['stored_path'])) {
            Storage::disk('public')->delete($chairman['stored_path']);
        }

        $path = $request->file('image')->store('who-we-are/chairman', 'public');

        $chairman['image']       = '/storage/' . $path;
        $chairman['stored_path'] = $path;
        $data['chairman']        = $chairman;

        WhoWeAreSection::updateOrCreate(
            ['section' => 'founding_team'],
            ['data'    => $data],
        );

        return back()->with('success', 'Chairman photo updated successfully.');
    }

    public function removeChairmanPhoto(Request $request)
    {
        $section  = WhoWeAreSection::where('section', 'founding_team')->first();
        $data     = $section?->data ?? [];
        $chairman = $data['chairman'] ?? [];

        if (!empty($chairman['stored_path'])) {
            Storage::disk('public')->delete($chairman['stored_path']);
        }

        $chairman['image']       = null;
        $chairman['stored_path'] = null;
        $data['chairman']        = $chairman;

        WhoWeAreSection::updateOrCreate(
            ['section' => 'founding_team'],
            ['data'    => $data],
        );

        return back()->with('success', 'Chairman photo removed.');
    }

    public function uploadMemberPhoto(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index   = (int) $request->input('index');
        $section = WhoWeAreSection::where('section', 'founding_team')->first();
        $data    = $section?->data ?? [];
        $members = $data['members'] ?? [];

        if (!empty($members[$index]['stored_path'])) {
            Storage::disk('public')->delete($members[$index]['stored_path']);
        }

        $path = $request->file('image')->store('who-we-are/members', 'public');

        if (!isset($members[$index])) {
            $members[$index] = [];
        }

        $members[$index]['image']       = '/storage/' . $path;
        $members[$index]['stored_path'] = $path;
        $data['members']                = $members;

        WhoWeAreSection::updateOrCreate(
            ['section' => 'founding_team'],
            ['data'    => $data],
        );

        return back()->with('success', 'Member photo updated successfully.');
    }

    public function removeMemberPhoto(Request $request)
    {
        $request->validate([
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index   = (int) $request->input('index');
        $section = WhoWeAreSection::where('section', 'founding_team')->first();
        $data    = $section?->data ?? [];
        $members = $data['members'] ?? [];

        if (isset($members[$index]) && !empty($members[$index]['stored_path'])) {
            Storage::disk('public')->delete($members[$index]['stored_path']);
        }

        if (isset($members[$index])) {
            $members[$index]['image']       = null;
            $members[$index]['stored_path'] = null;
        }

        $data['members'] = $members;

        WhoWeAreSection::updateOrCreate(
            ['section' => 'founding_team'],
            ['data'    => $data],
        );

        return back()->with('success', 'Member photo removed.');
    }
}
