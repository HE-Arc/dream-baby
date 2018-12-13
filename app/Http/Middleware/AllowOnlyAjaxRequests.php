<?php

namespace App\Http\Middleware;

use Closure;

class AllowOnlyAjaxRequests
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
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        } else {
            // Handle the non-ajax request
            return response('This route can only be accessed with ajax', 405);
        }

    }
}
