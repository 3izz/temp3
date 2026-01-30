<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug: Log the current user and role
        \Log::info('TeacherMiddleware: User authenticated: ' . Auth::check());
        if (Auth::check()) {
            \Log::info('TeacherMiddleware: User role: ' . Auth::user()->role);
        }
        
        if (Auth::check() && Auth::user()->role === 'teacher') {
            return $next($request);
        }

        // For debugging, let's allow access if no user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        abort(403, 'Unauthorized access - Teacher role required');
    }
}
