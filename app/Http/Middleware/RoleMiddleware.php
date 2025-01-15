<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response;

class RoleMiddleware
{
    /* *
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next

    public function handle($request, Closure $next, ...$roles)
    {
        if ($request->user() && in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
    */

    /** @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next */

    public function handle($request, Closure $next) : Response
    {
        $token = $request->header('Authorization');
        $authenticated = true;

        if(!$token) {
            $authenticated = false;
        }

        $bearerToken = json_decode(base64_decode($request->bearerToken()));

        if($authenticated) {
            if($bearerToken->roles > 1) {
                return $next($request);
            }
            return Response(['message' => 'Unauthorized Roles!!!']);
        }
        else {
            return Response(['message' => 'Unauthenticated!!!']);
        }
    }

}
