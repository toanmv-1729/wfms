<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Staff\StoreRequest;
use App\Http\Requests\Staff\UpdateRequest;
use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\ProjectRepository;

class StaffController extends Controller
{
    protected $roleRepository;
    protected $userRepository;
    protected $projectRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RoleRepository $roleRepository,
        UserRepository $userRepository,
        ProjectRepository $projectRepository
    ) {
        parent::__construct();
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
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

    public function getMyProjects()
    {
        $projects = $this->user
            ->projects()
            ->with('media')
            ->withCount('users')
            ->paginate(8);

        return view('projects.index', compact('projects'));
    }

    public function getProjectOverview($slug)
    {
        $project = $this->projectRepository->getProjectInfo($slug);
        $roles = [];
        foreach ($project->users as $user) {
            $roleName = $this->roleRepository->findOrFail($user->pivot->role_id)->name;
            $roles[$roleName] = $roles[$roleName] ?? [];
            array_push($roles[$roleName], $user);
        }

        return view('projects.overview', compact('project', 'roles'));
    }
}
