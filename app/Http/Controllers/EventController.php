<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Fetch only events whose end_date is today or in the future
        $events = Event::whereDate('end_date', '>=', Carbon::today())
            ->orderBy('start_date')
            ->get();

        return view('events.newEvent', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'location'    => 'nullable|string|max:255',
            'organizer'   => 'nullable|string|max:255',
        ]);

        $event = Event::create($request->all());
        $registrationLink = route('events.register', $event->id);
        $event->registration_link = $registrationLink;

        // 3. Generate QR code with Endroid
        $qr = QrCode::create($registrationLink)->setSize(300);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        // 4. Save QR code file in storage/public/qrcodes
        $fileName = 'qrcodes/event_' . $event->id . '.png';
        Storage::disk('public')->put($fileName, $result->getString());

        // 5. Save path to DB
        $event->qr_code_path = $fileName;
        $event->save();

        return redirect()->route('events.newEvent')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        // If request is AJAX, return JSON
        if (request()->ajax()) {
            return response()->json($event);
        }

        // Otherwise return a view (optional, if you ever want it)
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'location'    => 'nullable|string|max:255',
            'organizer'   => 'nullable|string|max:255',
        ]);

        $event->update($request->all());

        return redirect()->route('events.newEvent')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.newEvent')->with('success', 'Event deleted successfully.');
    }

    // ✅ API JSON endpoint (cleaner for JS)
    public function getEvent(Event $event)
    {
        return response()->json($event);
    }

    public function showPast()
    {
        $events = Event::whereDate('end_date', '<', Carbon::today())
            ->orderBy('start_date', 'desc')
            ->get();

        return view('events.pastEvent', compact('events'));
    }

    public function register()
    {
        $events = Event::all();
        return view('events.qr', compact('events'));
    }

    
}
