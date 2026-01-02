<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('renter')->check()) {
            return $next($request);
        }
        return redirect()->route('show-login')->with('error', 'You must be logged in to access the Renter Panel.');
    }
}
