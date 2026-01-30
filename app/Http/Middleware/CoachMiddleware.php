<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoachMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to access coach dashboard.');
        }

        // Check if user has coach role
        if (auth()->user()->role !== 'coach') {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized access attempt to coach dashboard', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role,
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            abort(403, 'Access denied. Coach privileges required.');
        }

        // Log successful access
        \Log::info('Coach dashboard accessed', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'ip' => $request->ip()
        ]);

        return $next($request);
    }
}
