<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // If user is logged in AND role_id===1 (admin), allow
        if (Auth::check() && Auth::user()->role_id === 1) {
            return $next($request);
        }

        // Otherwise bounce to a non‑admin route
        return redirect()->route('home');
    }
}
