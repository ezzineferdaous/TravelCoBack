<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        //return $next($request);
        // Check if the user is authenticated and has the correct role
        if (Auth::check() && Auth::user()->role->nom === $role) {
            return $next($request);
        }

        // If the user is not authorized, return a forbidden response
        return response()->json(['message' => 'Forbidden'], 403);

    }
}
