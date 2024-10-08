<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function register(UserRegisterRequest $request){
         $data = $request->validated();

         
         if(User::where("email", $data["email"])->count() == 1 ){
            throw new HttpResponseException(response([
                "errors"=> 'email sudah digunakan'
            ], 400));
         }

         $user = new User($data);
         $user->password = Hash::make($data["password"]);

         $user->save();

         return (new UserResource($user))->response()->setStatusCode(201);

    }

    public function login(UserLoginRequest $request){
        $data = $request->validated();
        $user = User::where("username", $data["username"]);


        if(!$user || !Hash::check($data["password"], $user["password"])){
            throw new HttpResponseException(response([
                "errors"=> "Login atau password salah"
            ], 400));
        }
        $user->token = Str::uuid()->toString();

        return new UserResource($user);
    }
}
