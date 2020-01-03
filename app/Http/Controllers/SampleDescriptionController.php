<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SampleDescription\StoreRequest;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\SampleDescriptionRepository;

class SampleDescriptionController extends Controller
{
    protected $projectRepository;
    protected $sampleDescriptionRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        SampleDescriptionRepository $sampleDescriptionRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->sampleDescriptionRepository = $sampleDescriptionRepository;
    }

    public function index($slug)
    {
        $this->authorize('samples.index');
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        if (!in_array($project->id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $sampleDescriptions = $this->sampleDescriptionRepository->getByAttributesWithRelation([
            'project_id' => $project->id,
        ], ['project', 'user']);

        return view('sample_descriptions.index', compact('project', 'sampleDescriptions'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('samples.store');
        if (!in_array($request->project, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        if ($request->status) {
            $this->sampleDescriptionRepository->updateStatus($request->project);
        }
        $this->sampleDescriptionRepository->create([
            'user_id' => $this->user->id,
            'project_id' => $request->project,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ]);
        toastr()->success('Sample Successfully Created');

        return redirect()->route('sample_descriptions.index', $request->slug);
    }

    public function update(StoreRequest $request, $id)
    {
        $this->authorize('samples.update');
        $sampleDescription = $this->sampleDescriptionRepository->findOrFail($id);
        if (!in_array($sampleDescription->project_id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        if ($request->status && !$sampleDescription->status) {
            $this->sampleDescriptionRepository->updateStatus($request->project);
        }
        $sampleDescription->update([
            'name' => $request->name ?? $sampleDescription->name,
            'description' => $request->description ?? $sampleDescription->description,
            'status' => $request->status ? 1 : 0,
        ]);
        toastr()->success('Sample Successfully Updated');

        return redirect()->route('sample_descriptions.index', $request->slug);
    }

    public function destroy($id)
    {
        $this->authorize('samples.destroy');
        $sampleDescription = $this->sampleDescriptionRepository->findOrFail($id);
        if (!in_array($sampleDescription->project_id, $this->user->projects->pluck('id')->toArray())) {
            return view('errors.403');
        }
        $slug = $sampleDescription->project->slug;
        $sampleDescription->delete();
        toastr()->success('Sample Successfully Deleted');

        return redirect()->route('sample_descriptions.index', $slug);
    }
}
