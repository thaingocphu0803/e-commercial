<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $locale = session('app_locale', config('app.locale'));
        $locale = Language::select('canonical')->where('current', 1)->first();
        // dd($locale->canonical);
        App::setLocale($locale->canonical);

        return $next($request);
    }
}
