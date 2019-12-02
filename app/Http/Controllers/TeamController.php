<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Requests\Team\StoreRequest;
use App\Contracts\Repositories\TeamRepository;

class TeamController extends Controller
{
    protected $teamRepository;

    public function __construct(
        TeamRepository $teamRepository
    ) {
        parent::__construct();
        $this->teamRepository = $teamRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \App\Http\Requests\Team\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
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
