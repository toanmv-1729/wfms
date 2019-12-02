<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Requests\Ticket\StoreRequest;
use App\Contracts\Repositories\TicketRepository;
use App\Contracts\Repositories\ProjectRepository;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $projectRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        ProjectRepository $projectRepository
    ) {
        parent::__construct();
        $this->ticketRepository = $ticketRepository;
        $this->projectRepository = $projectRepository;
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
    public function create($slug)
    {
        $project = $this->projectRepository->getProjectInfo($slug);

        return view('tickets.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\TicketService $ticketService
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, TicketService $ticketService)
    {
        $result = $ticketService->store($this->user, $request->all());
        $result ? toastr()->success('Ticket Successfully Created') : toastr()->error('Ticket Created Error');

        return redirect()->route('staffs.my_projects.overview', $request->project);
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
