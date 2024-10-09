<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->cookie("token");

        $isAuthenticated = true;

        if (!$token) {
            $isAuthenticated = false;
        }

        $user = User::where("token", $token)->first();

        Log::info($user);
        if (!$user) {
            $isAuthenticated = false;
        }
        if ($isAuthenticated) {
            return $next($request);
        } else {
            throw new HttpResponseException(response([
                "errors" => "UnAuthorized"
            ], 400));
        }

    }
}
