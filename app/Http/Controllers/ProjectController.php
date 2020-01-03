<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\Project\StoreRequest;
use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\ProjectRepository;

class ProjectController extends Controller
{
    protected $roleRepository;
    protected $userRepository;
    protected $projectRepository;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('projects.index');
        $projects = $this->projectRepository->getInCompany($this->user->company_id);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('projects.create');
        $description = "- What does the project do?\n- Project Objectives,...";
        $roles = $this->roleRepository->getByCompanyId($this->user->company_id);
        $users = $this->userRepository->getStaffInCompany($this->user->company_id);

        return view('projects.create', compact('description', 'roles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, ProjectService $projectService)
    {
        $this->authorize('projects.store');
        $projectService->store($this->user, $request->all());
        toastr()->success('Project Successfully Created');

        return redirect()->route('projects.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $this->authorize('projects.edit');
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        if (($this->user->user_type !== 'company' &&
                !in_array($this->user->id, $project->users->pluck('id')->toArray())) ||
            ($this->user->user_type === 'company' && $this->user->company_id !== $project->company_id)
        ) {
            return view('errors.403');
        }
        $description = "- What does the project do?\n- Project Objectives,...";
        $roles = $this->roleRepository->getByCompanyId($this->user->company_id);
        $users = $this->userRepository->getStaffInCompany($this->user->company_id);

        return view('projects.edit', compact('project', 'description', 'roles', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id, ProjectService $projectService)
    {
        $this->authorize('projects.update');
        $project = $this->projectRepository->findOrFail($id);
        if (($this->user->user_type !== 'company' &&
                !in_array($this->user->id, $project->users->pluck('id')->toArray())) ||
            ($this->user->user_type === 'company' && $this->user->company_id !== $project->company_id)
        ) {
            return view('errors.403');
        }
        $projectService->update($this->user, $project, $request->all());
        toastr()->success('Project Successfully Updated');

        return redirect()->route('staffs.my_projects.overview', $project->slug);
    }
}
