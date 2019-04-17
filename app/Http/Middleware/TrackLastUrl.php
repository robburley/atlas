<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class TrackLastUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Cookie::queue('atlas-last-url', redirect()->back()->getTargetUrl(), 60);

        return $next($request);
    }
}
