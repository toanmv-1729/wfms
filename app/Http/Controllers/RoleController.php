<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Role\StoreRequest;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $user = $this->user;
        $roles = $this->roleRepository->getByUserId($user->id);

        return view('roles.index', compact('user', 'roles'));
    }

    public function store(StoreRequest $request)
    {
    }

    public function update()
    {
    }

    public function destroy(Request $request, $id)
    {
    }
}
