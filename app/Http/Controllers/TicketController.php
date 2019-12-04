<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\TicketService;
use App\Http\Requests\Ticket\StoreRequest;
use App\Contracts\Repositories\TicketRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Http\Requests\Ticket\AddRelationTicketRequest;
use App\Contracts\Repositories\TicketRelationRepository;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $projectRepository;
    protected $ticketRelationRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        ProjectRepository $projectRepository,
        TicketRelationRepository $ticketRelationRepository
    ) {
        parent::__construct();
        $this->ticketRepository = $ticketRepository;
        $this->projectRepository = $projectRepository;
        $this->ticketRelationRepository = $ticketRelationRepository;
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

    public function createSubTicket($slug, $id)
    {
        $project = $this->projectRepository->getProjectInfo($slug);
        $ticketParent = $this->ticketRepository->findOrFail($id, ['id', 'title']);

        return view('tickets.create', compact('project', 'ticketParent'));
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = $this->ticketRepository->findOrFail($id);
        $relationTickets = $this->ticketRepository->getRelationTickets(
            $ticket->project->id,
            $id,
            ['id', 'title', 'tracker']
        );

        $ticketRelationIds = array_merge(
            $ticket->ticketRelations->pluck('ticket_relation_id')->toArray(),
            $ticket->ticketRelationsFlip->pluck('ticket_id')->toArray()
        );
        $ticketRelations = $this->ticketRepository->findMany(
            $ticketRelationIds,
            ['id', 'title', 'tracker']
        );

        return view('tickets.show', compact('ticket', 'relationTickets', 'ticketRelations'));
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

    public function addRelationTicket(AddRelationTicketRequest $request)
    {
        foreach ($request->relation_tickets as $relationTicketId) {
            $this->ticketRelationRepository->create([
                'ticket_id' => $request->tid,
                'ticket_relation_id' => $relationTicketId,
            ]);
        }
        toastr()->success('Relation Ticket Successfully');

        return redirect()->route('tickets.show', $request->tid);
    }
}
