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
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $versions = $this->versionRepository->getByAttributes([
            'project_id' => $project->id,
        ]);

        return view('versions.index', compact('versions', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Version $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, VersionService $versionService)
    {
        $result = $versionService->store($this->user, $request->all());
        $result ? toastr()->success('Version Successfully Created') : toastr()->error('Version Created Error');

        return redirect()->route('staffs.my_projects.overview', $request->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
