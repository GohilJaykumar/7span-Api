<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Auth;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class IsAdminMiddleware extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (Auth::user()->role == "User") {
                return response()->json(['status_code' => '402', 'message' => "You don't have admin access!"]);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status_code' => '401', 'message' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status_code' => '401', 'message' => 'Token is Expired']);
            } else {
                return response()->json(['status_code' => '401', 'message' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
