<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index() {
        $gallery = Gallary::all();
        return response()->json($gallery);
    }

    public function store(Request $request) {
        $user = Auth::user();
        if($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('gallery'), $imageName);

        $gallery = Gallary::create([
            'image' => 'gallery/'.$imageName
        ]);

        return response()->json(['message' => 'Image uploaded successfully', 'data' => $gallery]);
    }

    public function destroy($id) {
        $user = Auth::user();
        if($user->usertype !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $image = Gallary::find($id);
        if(!$image) return response()->json(['message' => 'Not found'], 404);

        if($image->image && File::exists(public_path($image->image))) {
            File::delete(public_path($image->image));
        }

        $image->delete();
        return response()->json(['message' => 'Image deleted successfully']);
    }
}
