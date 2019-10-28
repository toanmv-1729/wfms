<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Staff\StoreRequest;
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
        $user = $this->user;
        $staffs = $this->userRepository->getStaffInCompany($user->company_id);

        return view('staffs.index', compact('user', 'staffs'));
    }

    public function create()
    {
        $user = $this->user;
        $roles = $this->roleRepository->getByUserId($user->id);

        return view('staffs.create', compact('user', 'roles'));
    }

    public function store(StoreRequest $request)
    {
        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->name,
            'password' => bcrypt($request->name),
            'is_admin' => false,
            'user_type' => config('user.type.staff'),
            'created_by' => $this->user->id,
            'company_id' => $this->user->company_id,
        ]);
        $user->roles()->attach($request->roles);
        toastr()->success('Staff Successfully Created');

        return redirect()->route('staffs.index');
    }

    public function update()
    {
    }

    public function destroy(Request $request, $id)
    {
    }
}
