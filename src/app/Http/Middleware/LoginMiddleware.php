<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::id() > 0 && !$request->routeIs('auth.admin')){
            return redirect()->back();
        }elseif(Auth::id() && $request->routeIs('auth.admin')){
            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}
