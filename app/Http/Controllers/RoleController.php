<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\PermissionRepository;

class RoleController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $permissionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
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
        $permissions = $this->permissionRepository->all(['id', 'name']);

        return view('roles.create', compact('user', 'permissions'));
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

    public function edit($id)
    {
        $user = $this->user;
        $role = $this->roleRepository->findOrFail($id);
        $permissions = $this->permissionRepository->all(['id', 'name']);

        return view('roles.edit', compact('user', 'role', 'permissions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $role = $this->roleRepository->findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);
        $role->permissions()->sync($request->permissions);
        toastr()->success('Role Successfully Updated');

        return redirect()->route('roles.index');
    }

    public function destroy(Request $request, $id)
    {
        $role = $this->roleRepository->findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        toastr()->success('Role Successfully Deleted');

        return redirect()->route('roles.index');
    }
}
