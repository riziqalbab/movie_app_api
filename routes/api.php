<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get("/test", function(){
//     return response(json_encode([
//         "message"=> "sfd"
//     ]));
// });


Route::post("/users", [UserController::class, "register"]);
Route::post("/users/login", [UserController::class, "login"]);