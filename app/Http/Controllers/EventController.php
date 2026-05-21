<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationRequested;
use App\Mail\RegistrationApproved;
use App\Models\Registration;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with('organizer')->latest()->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required',
            'capacity'    => 'required|integer|min:1',
            'cover_image' => 'nullable|url|max:2048',
            'background_image' => 'nullable|string|max:2048',
            'theme_color' => 'nullable|string|max:20',
            'bg_color'    => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:100',
        ]);

        Auth::user()->events()->create($request->only([
            'title', 'description', 'location', 'date', 'time', 'capacity',
            'cover_image', 'background_image', 'theme_color', 'bg_color', 'font_family',
        ]));

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load('organizer', 'participants');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }
        $event->load('participants');
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required',
            'capacity'    => 'required|integer|min:1',
            'cover_image' => 'nullable|url|max:2048',
            'background_image' => 'nullable|string|max:2048',
            'theme_color' => 'nullable|string|max:20',
            'bg_color'    => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:100',
        ]);

        $event->update($request->only([
            'title', 'description', 'location', 'date', 'time', 'capacity',
            'cover_image', 'background_image', 'theme_color', 'bg_color', 'font_family',
        ]));

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully!');
    }

    /**
     * Register for the event (handles both logged-in and guest users).
     */
    public function register(Request $request, Event $event)
    {
        // Validation for guest registration
        if (!Auth::check()) {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            // Check if already registered (by email)
            if ($event->registrations()->where('email', $request->email)->exists()) {
                return back()->with('error', 'You have already requested to join this event.');
            }
        } else {
            // Check if already registered (by user_id)
            if ($event->registrations()->where('user_id', auth()->id())->exists()) {
                return back()->with('error', 'You have already requested to join this event.');
            }
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return back()->with('error', 'This event is already full.');
        }

        // Create registration
        $registration = $event->registrations()->create([
            'user_id' => Auth::id(),
            'name'    => Auth::check() ? Auth::user()->name : $request->name,
            'email'   => Auth::check() ? Auth::user()->email : $request->email,
            'status'  => 'pending',
        ]);

        // Send confirmation email to registrant and planner
        try {
            Mail::to($registration->email)->send(new RegistrationRequested($registration));
            Mail::to($event->organizer->email)->send(new RegistrationRequested($registration));
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error('Mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Your registration request has been submitted and is pending approval!');
    }

    /**
     * Approve a registration request.
     */
    public function approveRegistration(Event $event, Registration $registration)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $registration->update(['status' => 'confirmed']);

        // Send ticket email
        try {
            Mail::to($registration->email)->send(new RegistrationApproved($registration));
        } catch (\Exception $e) {
            \Log::error('Approval Mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Registration approved! Ticket has been sent.');
    }

    /**
     * Show the user dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $myEvents = $user->events()->withCount('participants')->latest()->get();
        $attendingEvents = $user->participatingEvents()->with('organizer')->latest()->get();

        return view('dashboard', compact('myEvents', 'attendingEvents'));
    }
}
