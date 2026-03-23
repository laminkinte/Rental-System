<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        if (!$user->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
