<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAPIAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has 'role_as' set to 1 (admin)
        if (auth()->check() && auth()->user()->role_as === 1) {
            return $next($request); // Allow access
        }

        // Deny access if not an admin
        return response()->json(['status' => 403, 'message' => 'Access Denied. You are not an admin.'], 403);
    }
}
