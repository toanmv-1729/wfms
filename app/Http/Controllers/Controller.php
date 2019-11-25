<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user = null;
    protected $repository;

    public function __construct(Repository $repository = null)
    {
        $this->repository = $repository;
        $this->middleware(function ($request, $next) {
            $this->user = $request->user($this->getGuard());
            view()->share('user', $this->user);
            return $next($request);
        });
    }

    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }
}
