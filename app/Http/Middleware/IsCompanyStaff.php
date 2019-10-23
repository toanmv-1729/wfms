<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsCompanyStaff
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
        $checkStaff = $request->user()->user_type === config('user.type.staff');

        if ($checkStaff) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }
}
