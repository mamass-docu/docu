<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfNotAuthenticated
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
        if(Authenticated())
            return redirect()->route('home');

        return $next($request);
    }
}
