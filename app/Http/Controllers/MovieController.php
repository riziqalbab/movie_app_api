<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class MovieController extends Controller
{
    public function all(Request $request)
    {
        $page = $request->query("page");
        
        $token = $request->cookie("token");
        $user = User::where("token", $token)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

Log::info($page);
        $movies = $user->movies()->paginate(10, ['*'], 'page', $page)->withPath('/');
        return response()->json($movies);
    }

    public function simpan(Request $request)
    {
        $token = $request->cookie("token");

        $user = User::where("token", $token)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            "title" => ["required", "string", "max:255"],
            "year" => ["required", "digits:4"],
            "img" => ["required", "image", "mimes:jpeg,png,jpg,gif", "max:10240"], // max 10MB
        ]);

        $path = $request->file('img')->store('uploads', 'public');
        $url = Storage::url($path);

        $movie = new Movie($validatedData);
        $movie->user_id = $user->id;
        $movie->img = $url;
        $movie->save();

        return response()->json([
            "message" => "Movie saved successfully",
        ], 201);
    }


    public function edit(Request $request, $id)
    {
        $token = $request->cookie("token");
        $user = User::where("token", $token)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $movie = Movie::where('id', $id)->where('user_id', $user->id)->first();

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $validatedData = $request->validate([
            "title" => ["required", "string", "max:255"],
            "year" => ["required", "digits:4"],
            "img" => ["nullable", "image", "mimes:jpeg,png,jpg,gif", "max:10240"], // Optional
        ]);

        if ($request->hasFile('img')) {
            if (Storage::disk('public')->exists($movie->img)) {
                Storage::disk('public')->delete($movie->img);
            }
            $path = $request->file('img')->store('uploads', 'public');
            $url = Storage::url($path);

            $movie->img = $url;
        }

        $movie->title = $validatedData['title'];
        $movie->year = $validatedData['year'];
        $movie->save();

        return response()->json([
            "message" => "Movie updated successfully",
            "movie" => $movie
        ]);
    }


}
