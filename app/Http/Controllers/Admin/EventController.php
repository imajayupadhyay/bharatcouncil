<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('type'), fn ($q) => $q->where('event_type', $request->type))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->where('title', 'like', "%{$request->search}%")
                          ->orWhere('location', 'like', "%{$request->search}%");
                });
            })
            ->orderBy('event_date', 'desc');

        $events = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Events/Index', [
            'admin'   => Auth::guard('admin')->user(),
            'events'  => $events,
            'filters' => $request->only('status', 'type', 'search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Events/Form', [
            'admin' => Auth::guard('admin')->user(),
            'event' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:events,slug'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'event_type'       => ['required', 'string', 'max:100'],
            'badge_text'       => ['nullable', 'string', 'max:50'],
            'badge_style'      => ['required', 'in:gold,teal,navy'],
            'event_date'       => ['required', 'date'],
            'event_time'       => ['nullable', 'string', 'max:100'],
            'location'         => ['nullable', 'string', 'max:255'],
            'registration_url' => ['nullable', 'url', 'max:500'],
            'status'           => ['required', 'in:draft,published'],
            'is_featured'      => ['boolean'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Event::uniqueSlug($data['title']);

        Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return Inertia::render('Admin/Events/Form', [
            'admin' => Auth::guard('admin')->user(),
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:events,slug,' . $event->id],
            'description'      => ['nullable', 'string', 'max:1000'],
            'event_type'       => ['required', 'string', 'max:100'],
            'badge_text'       => ['nullable', 'string', 'max:50'],
            'badge_style'      => ['required', 'in:gold,teal,navy'],
            'event_date'       => ['required', 'date'],
            'event_time'       => ['nullable', 'string', 'max:100'],
            'location'         => ['nullable', 'string', 'max:255'],
            'registration_url' => ['nullable', 'url', 'max:500'],
            'status'           => ['required', 'in:draft,published'],
            'is_featured'      => ['boolean'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Event::uniqueSlug($data['title'], $event->id);
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}
