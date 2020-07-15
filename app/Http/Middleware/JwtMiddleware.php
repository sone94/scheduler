<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
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
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException){
                return response()->json(['status' => 'Nece cura svaka, nece za dosljaka!']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }catch(JWTException $e){
            return redirect('/')->with(['status' => 'Token could not be parsed!']);
        }
        return $next($request);
    }
}
