<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Gallary;
use App\Models\Contact;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;

            if ($usertype == 'user') {
                $room = Room::all();
                $gallery = Gallary::all();
                return view('home.index', compact('room', 'gallery'));
            } else if ($usertype == 'admin') {
                return view('admin.index');
            } else {
                return \redirect()->back();
            }
        }
    }

    public function home()
    {
        $room = Room::all();
        $gallery = Gallary::all();
        return view('home.index', compact('room', 'gallery'));
    }

    // --- Rooms CRUD ---
    public function create_room()
    {
        return view('admin.create_room');
    }

    public function add_room(Request $req)
    {
        $room = new Room();

        if ($req->hasFile('image')) {
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('rooms'), $imageName);
            $room->image = 'rooms/' . $imageName;
        }

        $room->room_title  = $req->room_title;
        $room->description = $req->description;
        $room->price       = $req->price;
        $room->wifi        = $req->wifi;
        $room->room_type   = $req->room_type;
        $room->save();

        return redirect()->back()->with('success', 'Room added successfully!');
    }

    public function view_room()
    {
        $rooms = Room::all();
        return view('admin.view_room', compact('rooms'));
    }

    public function room_delete($id)
    {
        $data = Room::find($id);

        if ($data) {
            if ($data->image && File::exists(public_path($data->image))) {
                File::delete(public_path($data->image));
            }
            $data->delete();
            return redirect()->back()->with('success', 'Room deleted successfully!');
        }

        return redirect()->back()->with('error', 'Room not found!');
    }

    public function room_update($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.update_room', compact('room'));
    }

    public function room_update_confirm(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $room->room_title = $request->room_title;
        $room->description = $request->description;
        $room->price = $request->price;
        $room->wifi = $request->wifi;
        $room->room_type = $request->room_type;

        if ($request->hasFile('image')) {
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('rooms'), $imageName);
            $room->image = 'rooms/' . $imageName;
        }

        $room->save();

        return redirect()->route('room_update', $room->id)
            ->with('success', 'Room updated successfully');
    }

    // --- Bookings Management ---
    public function bookings()
    {
        $bookings = Booking::all();
        return view('admin.bookings', compact('bookings'));
    }

    public function booking_delete($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete();
            return redirect()->back()->with('success', 'Booking deleted successfully!');
        }

        return redirect()->back()->with('error', 'Booking not found!');
    }

    public function booking_approve($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status = 'approved';
            $booking->save();

            Mail::send('emails.booking_approved', ['booking' => $booking], function ($mail) use ($booking) {
                $mail->to($booking->email, $booking->name)
                     ->subject('Your booking has been approved!');
            });

            return redirect()->back()->with('success', 'Booking approved and email sent!');
        }
        return redirect()->back()->with('error', 'Booking not found!');
    }

    public function booking_reject($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status = 'rejected';
            $booking->save();

            Mail::send('emails.booking_rejected', ['booking' => $booking], function ($mail) use ($booking) {
                $mail->to($booking->email, $booking->name)
                     ->subject('Your booking has been rejected');
            });

            return redirect()->back()->with('success', 'Booking rejected and email sent!');
        }
        return redirect()->back()->with('error', 'Booking not found!');
    }

    // --- Gallery Management ---
    public function View_gallery()
    {
        $gallery = Gallary::all();
        return view('admin.gallery', compact('gallery'));
    }

    public function upload_gallery(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = time() . '_' . $request->image->getClientOriginalName();
        $request->image->move(public_path('gallery'), $imageName);

        $data = new Gallary();
        $data->image = 'gallery/' . $imageName;
        $data->save();

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    public function delete_gallery($id)
    {
        $image = Gallary::find($id);
        if ($image) {
            if (File::exists(public_path($image->image))) {
                File::delete(public_path($image->image));
            }
            $image->delete();
            return redirect()->back()->with('success', 'Image deleted successfully!');
        }
        return redirect()->back()->with('error', 'Image not found!');
    }

    // --- Messages Management ---
    public function all_messages()
    {
        $messages = Contact::all();
        return view('admin.all_messages', compact('messages'));
    }

    public function message_delete($id)
    {
        $message = Contact::find($id);

        if ($message) {
            $message->delete();
            return redirect()->back()->with('success', 'Message deleted successfully!');
        }

        return redirect()->back()->with('error', 'Message not found!');
    }

    public function showMailForm($id)
    {
        $message = Contact::findOrFail($id);
        return view('admin.send_mail', compact('message'));
    }

    public function sendMail(Request $request, $id)
    {
        $message = Contact::findOrFail($id);

        $details = [
            'greeting'    => $request->greeting,
            'body'        => $request->body,
            'action_text' => $request->action_text,
            'action_url'  => $request->action_url,
            'end_line'    => $request->end_line,
        ];

        Mail::send('emails.send_message', $details, function ($mail) use ($message) {
            $mail->to($message->email, $message->name)
                 ->subject('Message from Admin');
        });

        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
