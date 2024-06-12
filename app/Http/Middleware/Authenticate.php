<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            // Check if the token is valid before proceeding
            $user = JWTAuth::parseToken()->authenticate();

            return parent::handle($request, $next, ...$guards);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid.'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is not provided.'], 401);
        } catch (AuthenticationException $e) {
            // If the request expects JSON, we'll return a JSON response
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
