<?php

namespace App\Http\Middleware;

use Closure;

// use App\CustomMethods\Auth\Gate;

use Illuminate\Support\Str;

class CheckIfRoleIsAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        abort_if($role != $GLOBALS['user']->role, 401);

        return $next($request);
    }
}
