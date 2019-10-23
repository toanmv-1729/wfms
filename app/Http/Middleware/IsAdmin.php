<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsAdmin
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
        $checkAdmin = $request->user()->is_admin && $request->user()->user_type === config('user.type.admin');

        if ($checkAdmin) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }
}
