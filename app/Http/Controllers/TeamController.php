<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Requests\Team\StoreRequest;
use App\Contracts\Repositories\TeamRepository;
use App\Contracts\Repositories\ProjectRepository;

class TeamController extends Controller
{
    protected $teamRepository;
    protected $projectRepository;

    public function __construct(
        TeamRepository $teamRepository,
        ProjectRepository $projectRepository
    ) {
        parent::__construct();
        $this->teamRepository = $teamRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $this->authorize('teams.index');
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $teams = $this->teamRepository->getByAttributesWithRelation(['project_id' => $project->id], ['users']);

        return view('teams.index', compact('teams', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Team\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('teams.store');
        DB::beginTransaction();
        try {
            $team = $this->teamRepository->create([
                'user_id' => $this->user->id,
                'project_id' => $request->project,
                'name' => $request->name,
            ]);
            $team->users()->attach($request->users);
            DB::commit();
        } catch(Exception $exception) {
            toastr()->error('Team Created Error');
            Log::error($exception);
            DB::rollBack();
        }
        toastr()->success('Team Successfully Created');

        return redirect()->route('teams.index', $team->project->slug);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $this->authorize('teams.update');
        $team = $this->teamRepository->findOrFail($id);
        $slug = $team->project->slug;
        DB::beginTransaction();
        try {
            $team->update([
                'name' => $request->name,
            ]);
            $team->users()->sync($request->users);
            DB::commit();
        } catch(Exception $exception) {
            toastr()->error('Team Updated Error');
            Log::error($exception);
            DB::rollBack();
        }
        toastr()->success('Team Successfully Updated');

        return redirect()->route('teams.index', $slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('teams.destroy');
        $team = $this->teamRepository->findOrFail($id);
        $slug = $team->project->slug;
        DB::beginTransaction();
        try {
            $team->users()->detach();
            $team->delete();
            DB::commit();
        } catch(Exception $exception) {
            toastr()->error('Team Deleted Error');
            Log::error($exception);
            DB::rollBack();
        }
        toastr()->success('Team Successfully Deleted');

        return redirect()->route('teams.index', $slug);
    }
}
