<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\TicketHistoryRepository;

class ActivityController extends Controller
{
    protected $projectRepository;
    protected $ticketHistoryRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        TicketHistoryRepository $ticketHistoryRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->ticketHistoryRepository = $ticketHistoryRepository;
    }

    public function index($slug)
    {
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $ticketHistories = $this->ticketHistoryRepository->getActivities([
            'project_id' => $project->id,
            'user_id' => $this->user->id,
        ]);

        return view('activities.index', compact('project', 'ticketHistories'));
    }

    public function all()
    {
        $ticketHistories = $this->ticketHistoryRepository->getActivities([
            'user_id' => $this->user->id,
        ]);

        return view('activities.index', compact('ticketHistories'));
    }
}
