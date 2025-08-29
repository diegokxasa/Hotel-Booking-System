<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::all();
        return response()->json($bookings);
    }

    public function show($id)
    {
        $user = Auth::user();
        if ($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_intent_id' => 'required|string',
            'payment_status' => 'required|string|in:paid,unpaid',
        ]);

        $room = Room::findOrFail($request->room_id);

        $existingBooking = Booking::where('room_id', $room->id)
            ->where(function($q) use ($request) {
                $q->where('start_date', '<=', $request->end_date)
                  ->where('end_date', '>=', $request->start_date);
            })->first();

        if ($existingBooking) {
            return response()->json(['message' => 'Room already booked for selected dates'], 409);
        }

        $booking = Booking::create([
            'room_id' => $room->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'payment_intent_id' => $request->payment_intent_id,
            'payment_status' => $request->payment_status,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->status = $request->status;
        $booking->save();

        if (in_array($booking->status, ['approved', 'rejected'])) {
            $subject = $booking->status === 'approved' ? 'Your booking has been approved' : 'Your booking has been rejected';
            Mail::send('emails.booking_status', ['booking' => $booking], function($mail) use ($booking, $subject){
                $mail->to($booking->email, $booking->name)
                     ->subject($subject);
            });
        }

        return response()->json([
            'message' => 'Booking status updated',
            'booking' => $booking
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
    public function paymentStatus($id) {
    $booking = \App\Models\Booking::find($id);
    if(!$booking) return response()->json(['message' => 'Booking not found'], 404);

    return response()->json([
        'booking_id' => $booking->id,
        'payment_status' => $booking->payment_status
    ]);
}
}
