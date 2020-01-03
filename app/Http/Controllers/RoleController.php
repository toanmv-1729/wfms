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
        $this->authorize('roles.index');
        $roles = $this->roleRepository->getByCompanyId($this->user->company_id);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('roles.create');
        $permissions = $this->permissionRepository->all(['id', 'name']);

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('roles.store');
        $role = $this->roleRepository->create([
            'user_id' => $this->user->id,
            'company_id' => $this->user->company_id,
            'name' => $request->name,
        ]);
        $role->permissions()->attach($request->permissions);
        toastr()->success('Role Successfully Created');

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $this->authorize('roles.edit');
        $role = $this->roleRepository->findOrFail($id);
        if ($this->user->id !== $role->user_id) {
            return view('errors.403');
        }
        $permissions = $this->permissionRepository->all(['id', 'name']);

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->authorize('roles.update');
        $role = $this->roleRepository->findOrFail($id);
        if ($this->user->id !== $role->user_id) {
            return view('errors.403');
        }
        $role->update([
            'name' => $request->name,
        ]);
        $role->permissions()->sync($request->permissions);
        toastr()->success('Role Successfully Updated');

        return redirect()->route('roles.index');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('roles.destroy');
        $role = $this->roleRepository->findOrFail($id);
        if ($this->user->id !== $role->user_id) {
            return view('errors.403');
        }
        $role->permissions()->detach();
        $role->delete();

        toastr()->success('Role Successfully Deleted');

        return redirect()->route('roles.index');
    }
}
