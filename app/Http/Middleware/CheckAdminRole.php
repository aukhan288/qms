<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role_id == 1) { // Assuming 1 is the ID for 'admin' role
            return $next($request);
        }

        // If not, redirect them to a page (e.g., home or access denied page)
        return redirect()->back()->with('error', 'You do not have admin access');
    }
}







