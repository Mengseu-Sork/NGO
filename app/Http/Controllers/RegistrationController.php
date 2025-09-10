<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(Event $event)
    {
        return view('registrations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'gender'=> 'nullable|in:Male,Female',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

        Registration::create([
            'event_id' => $event->id,
            'name'     => $request->name,
            'gender'   => $request->gender,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'organization' => $request->organization,
        ]);

        return redirect()->route('registrations.thank', $event->id)
            ->with('success', 'You have registered successfully!');
    }

    // Admin view: list registrations
    public function index(Event $event)
    {
        $registrations = $event->registrations()->latest()->get();
        return view('registrations.index', compact('event', 'registrations'));
    }

    public function thankYou()
    {
        return view('registrations.thank');
    }
}

