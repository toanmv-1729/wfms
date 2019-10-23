<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class IsCompany
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
        $checkCompany = $request->user()->user_type === config('user.type.company');

        if ($checkCompany) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }
}
