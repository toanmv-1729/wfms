<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VersionService;
use App\Http\Requests\Version\StoreRequest;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\VersionRepository;

class VersionController extends Controller
{
    protected $projectRepository;
    protected $versionRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        VersionRepository $versionRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->versionRepository = $versionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $this->authorize('versions.index');
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        if (!in_array($project->id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $versions = $this->versionRepository->getByAttributesWithRelation([
            'project_id' => $project->id,
        ], ['tickets', 'tasks', 'bugs', 'features', 'ticketsClosed', 'tasksClosed', 'bugsClosed', 'featuresClosed']);

        return view('versions.index', compact('versions', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Version $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, VersionService $versionService)
    {
        $this->authorize('versions.store');
        if (!in_array($request->project, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $result = $versionService->store($this->user, $request->all());
        $result ? toastr()->success('Version Successfully Created') : toastr()->error('Version Created Error');

        return redirect()->route('versions.index', $request->slug);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id, VersionService $versionService)
    {
        $this->authorize('versions.update');
        $version = $this->versionRepository->findOrFail($id);
        if (!in_array($version->project_id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $result = $versionService->update($this->user, $version, $request->all());
        $result ? toastr()->success('Version Successfully Updated') : toastr()->error('Version Updated Error');

        return redirect()->route('versions.index', $request->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('versions.destroy');
        $version = $this->versionRepository->findOrFail($id);
        if (!in_array($version->project_id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $slug = optional($version->project)->slug;
        $result = $version->delete();
        $result ? toastr()->success('Version Successfully Deleted') : toastr()->error('Version Deleted Error');

        return redirect()->route('versions.index', $slug);
    }
}
