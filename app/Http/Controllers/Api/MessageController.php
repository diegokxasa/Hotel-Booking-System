<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        return response()->json(['message' => 'Message sent successfully', 'data' => $contact]);
    }

    public function index() {
        $user = Auth::user();
        if($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $messages = Contact::all();
        return response()->json($messages);
    }

    public function show($id) {
        $user = Auth::user();
        if($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $message = Contact::find($id);
        if(!$message) return response()->json(['message' => 'Not found'], 404);
        return response()->json($message);
    }

    public function destroy($id) {
        $user = Auth::user();
        if($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $message = Contact::find($id);
        if(!$message) return response()->json(['message' => 'Not found'], 404);
        $message->delete();
        return response()->json(['message' => 'Message deleted successfully']);
    }
}

