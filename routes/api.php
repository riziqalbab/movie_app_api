<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
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


Route::post("/user", [UserController::class, "register"]);
Route::post("/user/login", [UserController::class, "login"]);

Route::middleware([AuthMiddleware::class])->group(function(){
    Route::get("/user/get", [UserController::class, "get"]);
});