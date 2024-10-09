<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post("/user", [UserController::class, "register"]);

Route::middleware([AuthMiddleware::class])->group(function(){
    Route::post("/user/login", [UserController::class, "login"]);
    Route::post("/user/logout", [UserController::class, "logout"]);
    Route::get("/user/get", [UserController::class, "get"]);
    Route::post("/movie/store", [MovieController::class, "simpan"]);
    Route::post("/movie/edit/{id}", [MovieController::class, "simpan"]);
    Route::get("/movie", [MovieController::class, "all"]);

});