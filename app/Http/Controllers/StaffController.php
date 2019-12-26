<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Staff\StoreRequest;
use App\Http\Requests\Staff\UpdateRequest;
use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Notifications\SendAccountInfomationNotification;

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
        $this->authorize('staffs.index');
        $staffs = $this->userRepository->getStaffInCompany($this->user->company_id);

        return view('staffs.index', compact('staffs'));
    }

    public function create()
    {
        $this->authorize('staffs.create');
        $roles = $this->roleRepository->getByCompanyId($this->user->company_id);

        return view('staffs.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('staffs.store');
        $password = str_random(12);
        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(str_random(12)),
            'is_admin' => false,
            'user_type' => config('user.type.staff'),
            'created_by' => $this->user->id,
            'company_id' => $this->user->company_id,
        ]);
        if ($user) {
            $user->notify(new SendAccountInfomationNotification($user->email, $password));
        }
        $user->roles()->attach($request->roles);
        toastr()->success('Staff Successfully Created');

        return redirect()->route('staffs.index');
    }

    public function edit($id)
    {
        $this->authorize('staffs.edit');
        $staff = $this->userRepository->findOrFail($id);
        $roles = $this->roleRepository->getByCompanyId($this->user->company_id);

        return view('staffs.edit', compact('staff', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->authorize('staffs.update');
        $staff = $this->userRepository->findOrFail($id);
        $staff->roles()->sync($request->roles);
        toastr()->success('Staff Successfully Updated');

        return redirect()->route('staffs.index');
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('staffs.destroy');
        $staff = $this->userRepository->findOrFail($id);
        $staff->update([
            'email' => now()->format('YmdHis') . $staff->email,
        ]);
        $staff->roles()->detach();
        $staff->delete();
        toastr()->success('Staff Successfully Deleted');

        return redirect()->route('staffs.index');
    }

    public function getMyProjects()
    {
        $this->authorize('staffs.getMyProjects');
        $projects = $this->user
            ->projects()
            ->with('media')
            ->withCount('users')
            ->paginate(8);

        return view('projects.index', compact('projects'));
    }

    public function getProjectOverview($slug)
    {
        $this->authorize('staffs.getProjectOverview');
        $project = $this->projectRepository->getProjectInfo($slug);
        $roles = [];
        foreach ($project->users as $user) {
            $roleId = $user->pivot->role_id;
            $roles[$roleId] = $roles[$roleId] ?? [];
            array_push($roles[$roleId], $user);
        }
        $roleNames = $this->roleRepository->findMany(array_keys($roles))->pluck('id', 'name')->toArray();
        foreach ($roleNames as $roleName => $value) {
            $roles[$roleName] = $roles[$value];
            unset($roles[$value]);
        }

        return view('projects.overview', compact('project', 'roles'));
    }
}
