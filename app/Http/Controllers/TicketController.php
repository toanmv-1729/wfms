<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\TicketService;
use App\Http\Requests\Ticket\StoreRequest;
use App\Contracts\Repositories\TicketRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\TicketHistoryRepository;
use App\Http\Requests\Ticket\AddRelationTicketRequest;
use App\Contracts\Repositories\TicketRelationRepository;
use App\Contracts\Repositories\SampleDescriptionRepository;

class TicketController extends Controller
{
    protected $ticketRepository;
    protected $projectRepository;
    protected $ticketHistoryRepository;
    protected $ticketRelationRepository;
    protected $sampleDescriptionRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        ProjectRepository $projectRepository,
        TicketHistoryRepository $ticketHistoryRepository,
        TicketRelationRepository $ticketRelationRepository,
        SampleDescriptionRepository $sampleDescriptionRepository
    ) {
        parent::__construct();
        $this->ticketRepository = $ticketRepository;
        $this->projectRepository = $projectRepository;
        $this->ticketHistoryRepository = $ticketHistoryRepository;
        $this->ticketRelationRepository = $ticketRelationRepository;
        $this->sampleDescriptionRepository = $sampleDescriptionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $this->authorize('tickets.index');
        $project = $this->projectRepository->findByAttributes(['slug' => $slug], ['users', 'versions']);
        $tickets = $this->ticketRepository->getByCustomConditions($project->id, $request->all());

        return view('tickets.index', compact('tickets', 'project'));
    }

    public function all()
    {
        $this->authorize('tickets.all');
        $projectIds = $this->user->projects->pluck('id')->toArray();
        $tickets = $this->ticketRepository->getByProjectIds($projectIds);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $this->authorize('tickets.create');
        $project = $this->projectRepository->getProjectInfo($slug);
        $sample = $this->sampleDescriptionRepository->findActiveSampleInProject($project->id);

        return view('tickets.create', compact('project', 'sample'));
    }

    public function createSubTicket($slug, $id)
    {
        $this->authorize('tickets.createSubTicket');
        $project = $this->projectRepository->getProjectInfo($slug);
        $ticketParent = $this->ticketRepository->findOrFail($id, ['id', 'title']);
        $sample = $this->sampleDescriptionRepository->findActiveSampleInProject($project->id);

        return view('tickets.create', compact('project', 'ticketParent', 'sample'));
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
        $this->authorize('tickets.store');
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
        $this->authorize('tickets.show');
        $ticket = $this->ticketRepository->findOrFail($id);
        $notInIds = $ticket->ticketRelations->pluck('ticket_relation_id')->toArray();
        array_push($notInIds, $ticket->id);
        $relationTickets = $this->ticketRepository->getRelationTickets(
            $ticket->project->id,
            $notInIds,
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
        $ticketHistories = $this->ticketHistoryRepository->getList($id);

        return view('tickets.show', compact('ticket', 'relationTickets', 'ticketRelations', 'ticketHistories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('tickets.edit');
        $ticket = $this->ticketRepository->findOrFail($id);

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id, TicketService $ticketService)
    {
        $this->authorize('tickets.update');
        $ticket = $this->ticketRepository->findOrFail($id);
        $result = $ticketService->update($this->user, $ticket, $request->all());
        $result ? toastr()->success('Ticket Successfully Updated') : toastr()->error('Ticket Updated Error');

        return redirect()->route('tickets.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('tickets.destroy');
        $ticket = $this->ticketRepository->findOrFail($id);
        $slug = $ticket->project->slug;
        $result = $ticket->delete();
        $result ? toastr()->success('Ticket Successfully Deleted') : toastr()->error('Ticket Deleted Error');

        return redirect()->route('tickets.index', $slug);
    }

    public function addRelationTicket(AddRelationTicketRequest $request)
    {
        $this->authorize('tickets.addRelationTicket');
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
