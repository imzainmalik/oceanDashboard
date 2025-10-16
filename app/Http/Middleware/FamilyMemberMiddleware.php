<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FamilyMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role->id == 3) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized');
        }
        if (!Auth::check()) {
            return redirect()->route('login'); // ya abort(403) if you don't want public access
        }
    }
}
