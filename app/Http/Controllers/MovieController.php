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
    public function all()
    {
        $movie = Movie::all();
        return response(json_encode($movie));
    }

    public function simpan(Request $request)
    {


        $token = $request->cookie("token");

        $user = User::where("token", $token)->first();
        $user_id = $user->id;


        $movie = $request->validate([
            "title" => ["required"],
            "year" => ["required"],
            "img"=>File::image()
            ->min('1kb')
            ->max('10mb')
        ]);



        Log::info($request);
    

        // Storage::disk("public")->put($movie["img"], "img");
        $path = $request->file('img')->store('uploads', 'public'); 
        $url = Storage::url($path);

        $movie = new Movie($movie);
        $movie->user_id = $user_id;
        $movie->img = $url;
        $movie->save();

        return response(json_encode([
            "fd" => 'sd'
        ]));
    }
}
