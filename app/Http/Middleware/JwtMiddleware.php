<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
            $user = JWTAuth::parseToken()->authenticate();
               
        } catch (Exception $e) {
            $message = 'Authorization Token not found.';
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $message = 'Token is Invalid.';
             
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
             
                $message = 'Token is Expired.';
            }
            $data['status'] = false;
            $data['code'] = 401;
            $data['message'] = $message;
                
            return response()->json($data, 401);
        }

        return $next($request);
    }
}
