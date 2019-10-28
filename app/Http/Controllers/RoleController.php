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

    public function create()
    {
        $user = $this->user;

        return view('roles.create', compact('user'));
    }

    public function store(StoreRequest $request)
    {
        $role = $this->roleRepository->create([
            'user_id' => $this->user->id,
            'name' => $request->name,
        ]);
        $role->permissions()->attach($request->permissions);
        toastr()->success('Role Successfully Created');

        return redirect()->route('roles.index');
    }

    public function update()
    {
    }

    public function destroy(Request $request, $id)
    {
    }
}
