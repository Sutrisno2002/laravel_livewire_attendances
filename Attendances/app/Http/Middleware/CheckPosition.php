<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPosition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $position
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $position)
    {
        if (Auth::check() && Auth::user()->position_id == $position) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Unauthorized');
    }
}

