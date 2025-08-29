<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Gallary;

class HomeController extends Controller
{
    // --- Room Details ---
    public function room_details($id)
    {
        $room = Room::find($id);
        return view('home.room_details', compact('room'));
    }

    // --- Add Booking ---
    public function add_booking(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_intent_id' => 'required|string', 
        ]);

        $room = Room::findOrFail($id);

        $start = $request->start_date;
        $end = $request->end_date;

        $existingBooking = Booking::where('room_id', $id)
            ->where(function ($q) use ($start, $end) {
                $q->where(function ($query) use ($start, $end) {
                    $query->where('start_date', '<=', $end)
                          ->where('end_date', '>=', $start);
                });
            })->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'Sorry, this room is already booked for the selected dates.');
        }

        $booking = Booking::create([
            'room_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'start_date' => $start,
            'end_date' => $end,
            'payment_intent_id' => $request->payment_intent_id,
            'payment_status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Your booking has been successfully made!');
    }

    // --- Contact Form ---
    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        Contact::create($request->only(['name','email','phone','message']));
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
