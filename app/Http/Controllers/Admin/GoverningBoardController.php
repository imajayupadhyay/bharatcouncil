<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoverningBoardSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GoverningBoardController extends Controller
{
    public function index()
    {
        $sections = GoverningBoardSection::all()->keyBy('section')->map->data;

        return Inertia::render('Admin/GoverningBoard/Index', [
            'admin'    => Auth::guard('admin')->user(),
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

    public function uploadChairmanImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $chairmanSection = GoverningBoardSection::where('section', 'chairman')->first();
        $data = $chairmanSection?->data ?? [];

        // Delete old uploaded image
        if (!empty($data['stored_path'])) {
            Storage::disk('public')->delete($data['stored_path']);
        }

        $path = $request->file('image')->store('governing-board/chairman', 'public');
        $url  = '/storage/' . $path;

        $data['image']       = $url;
        $data['stored_path'] = $path;

        GoverningBoardSection::updateOrCreate(
            ['section' => 'chairman'],
            ['data'    => $data],
        );

        return back()->with('success', 'Chairman photo updated successfully.');
    }

    public function removeChairmanImage(Request $request)
    {
        $chairmanSection = GoverningBoardSection::where('section', 'chairman')->first();
        $data = $chairmanSection?->data ?? [];

        if (!empty($data['stored_path'])) {
            Storage::disk('public')->delete($data['stored_path']);
        }

        $data['image']       = null;
        $data['stored_path'] = null;

        GoverningBoardSection::updateOrCreate(
            ['section' => 'chairman'],
            ['data'    => $data],
        );

        return back()->with('success', 'Chairman photo removed.');
    }

    public function uploadOfficerImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $section = GoverningBoardSection::where('section', 'executive_officers')->first();
        $data    = $section?->data ?? [];
        $officers = $data['officers'] ?? [];

        if (!empty($officers[$index]['stored_path'])) {
            Storage::disk('public')->delete($officers[$index]['stored_path']);
        }

        $path = $request->file('image')->store('governing-board/officers', 'public');
        $url  = '/storage/' . $path;

        if (!isset($officers[$index])) {
            $officers[$index] = [];
        }

        $officers[$index]['image']       = $url;
        $officers[$index]['stored_path'] = $path;

        $data['officers'] = $officers;

        GoverningBoardSection::updateOrCreate(
            ['section' => 'executive_officers'],
            ['data'    => $data],
        );

        return back()->with('success', 'Officer photo updated successfully.');
    }

    public function uploadMemberImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $section = GoverningBoardSection::where('section', 'board_members')->first();
        $data    = $section?->data ?? [];
        $members = $data['members'] ?? [];

        if (!empty($members[$index]['stored_path'])) {
            Storage::disk('public')->delete($members[$index]['stored_path']);
        }

        $path = $request->file('image')->store('governing-board/members', 'public');
        $url  = '/storage/' . $path;

        if (!isset($members[$index])) {
            $members[$index] = [];
        }

        $members[$index]['image']       = $url;
        $members[$index]['stored_path'] = $path;

        $data['members'] = $members;

        GoverningBoardSection::updateOrCreate(
            ['section' => 'board_members'],
            ['data'    => $data],
        );

        return back()->with('success', 'Member photo updated successfully.');
    }

    public function removeMemberImage(Request $request)
    {
        $request->validate([
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $section = GoverningBoardSection::where('section', 'board_members')->first();
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

        GoverningBoardSection::updateOrCreate(
            ['section' => 'board_members'],
            ['data'    => $data],
        );

        return back()->with('success', 'Member photo removed.');
    }

    public function removeOfficerImage(Request $request)
    {
        $request->validate([
            'index' => ['required', 'integer', 'min:0'],
        ]);

        $index = (int) $request->input('index');

        $section  = GoverningBoardSection::where('section', 'executive_officers')->first();
        $data     = $section?->data ?? [];
        $officers = $data['officers'] ?? [];

        if (isset($officers[$index]) && !empty($officers[$index]['stored_path'])) {
            Storage::disk('public')->delete($officers[$index]['stored_path']);
        }

        if (isset($officers[$index])) {
            $officers[$index]['image']       = null;
            $officers[$index]['stored_path'] = null;
        }

        $data['officers'] = $officers;

        GoverningBoardSection::updateOrCreate(
            ['section' => 'executive_officers'],
            ['data'    => $data],
        );

        return back()->with('success', 'Officer photo removed.');
    }
}
