<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    public function show($id)
    {
        $room = Room::find($id);
        if ($room) {
            return response()->json($room);
        }
        return response()->json(['message' => 'Room not found'], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'wifi' => 'nullable|string',
            'room_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $roomData = $request->only(['room_title', 'description', 'price', 'wifi', 'room_type']);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('rooms'), $imageName);
            $roomData['image'] = 'rooms/' . $imageName;
        }

        $room = Room::create($roomData);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room
        ]);
    }

    public function update(Request $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $request->validate([
            'room_title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'wifi' => 'nullable|string',
            'room_type' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $roomData = $request->only(['room_title', 'description', 'price', 'wifi', 'room_type']);

        if ($request->hasFile('image')) {
            if ($room->image && File::exists(public_path($room->image))) {
                File::delete(public_path($room->image));
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('rooms'), $imageName);
            $roomData['image'] = 'rooms/' . $imageName;
        }

        $room->update($roomData);

        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room
        ]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        if ($room->image && File::exists(public_path($room->image))) {
            File::delete(public_path($room->image));
        }

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully']);
    }
}
