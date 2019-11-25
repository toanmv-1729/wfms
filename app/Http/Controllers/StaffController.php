<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Staff\StoreRequest;
use App\Http\Requests\Staff\UpdateRequest;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\RoleRepository;

class StaffController extends Controller
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
        $staffs = $this->userRepository->getStaffInCompany($this->user->company_id);

        return view('staffs.index', compact('staffs'));
    }

    public function create()
    {
        $roles = $this->roleRepository->getByUserId($this->user->id);

        return view('staffs.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => str_slug($request->name, '.'),
            'password' => bcrypt(str_slug($request->name, '.')),
            'is_admin' => false,
            'user_type' => config('user.type.staff'),
            'created_by' => $this->user->id,
            'company_id' => $this->user->company_id,
        ]);
        $user->roles()->attach($request->roles);
        toastr()->success('Staff Successfully Created');

        return redirect()->route('staffs.index');
    }

    public function edit($id)
    {
        $staff = $this->userRepository->findOrFail($id);
        $roles = $this->roleRepository->getByUserId($this->user->id);

        return view('staffs.edit', compact('staff', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $staff = $this->userRepository->findOrFail($id);
        $staff->roles()->sync($request->roles);
        toastr()->success('Staff Successfully Updated');

        return redirect()->route('staffs.index');
    }

    public function destroy(Request $request, $id)
    {
        $staff = $this->userRepository->findOrFail($id);
        $staff->roles()->detach();
        $staff->delete();
        toastr()->success('Staff Successfully Deleted');

        return redirect()->route('staffs.index');
    }
}
