<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\SpendTimeRepository;

class SpendTimeController extends Controller
{
    protected $projectRepository;
    protected $spendTimeRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        SpendTimeRepository $spendTimeRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->spendTimeRepository = $spendTimeRepository;
    }

    public function index($slug)
    {
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $spendTimes = $this->spendTimeRepository->getByAttributesWithRelation([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
        ], ['project', 'ticket', 'user']);

        return view('spend_times.index', compact('spendTimes'));
    }

    public function all()
    {
        $spendTimes = $this->spendTimeRepository->getByAttributesWithRelation([
            'user_id' => $this->user->id,
        ], ['project', 'ticket', 'user']);

        return view('spend_times.index', compact('spendTimes'));
    }
}
