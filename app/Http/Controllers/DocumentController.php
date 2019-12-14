<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\Document\StoreRequest;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\DocumentRepository;

class DocumentController extends Controller
{
    protected $projectRepository;
    protected $documentRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        DocumentRepository $documentRepository
    ) {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->documentRepository = $documentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $documents = $this->documentRepository->getRootItemsInProject($project->id);

        return view('documents.index', compact('project', 'documents'));
    }

    public function indexChild($slug, $uuid)
    {
        $project = $this->projectRepository->findByAttributes(['slug' => $slug]);
        $currentDocument = $this->documentRepository->findByAttributes(['uuid' => $uuid]);
        $documents = $this->documentRepository->getChildDocuments($project->id, $currentDocument->id);

        $parentIds = [];
        $parentDocument = $currentDocument;
        while ($parentDocument && $parentDocument->parent_id) {
            array_push($parentIds, $parentDocument->parent_id);
            $parentDocument = $this->documentRepository->find($parentDocument->parent_id);
        }

        $breadcrumbDocuments = $this->documentRepository->getBreadcrumbDocuments($parentIds);

        return view('documents.index', compact('project', 'documents', 'currentDocument', 'breadcrumbDocuments'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            if ($request->parent) {
                $parentId = $this->documentRepository->findByAttributes([
                    'uuid' => $request->parent
                ])->id;
            }
            $document = $this->documentRepository->create([
                'user_id' => $this->user->id,
                'project_id' => $request->project,
                'parent_id' => $request->parent ? $parentId : null,
                'name' => $request->name,
                'type' => $request->type ? config('document.type.file') : config('document.type.folder'),
                'link' => $request->link,
            ]);
            $document->update([
                'uuid' => md5($document->id . now()->format('YmdHis')),
            ]);
        } catch (Exception $exception) {
            toastr()->error('Document Create Error');
        }
        toastr()->success('Document Successfully Created');

        return $request->parent ?
            redirect()->route('documents.child', ['slug' => $request->slug, 'uuid' => $request->parent]) :
            redirect()->route('documents.index', $request->slug);
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
    public function update(StoreRequest $request, $id)
    {
        $document = $this->documentRepository->findOrFail($id);
        $document->update([
            'name' => $request->name ?? $document->name,
            'link' => $request->link ?? $document->link,
        ]);
        toastr()->success('Document Successfully Created');

        return $request->parent ?
            redirect()->route('documents.child', ['slug' => $request->slug, 'uuid' => $request->parent]) :
            redirect()->route('documents.index', $request->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = $this->documentRepository->findOrFail($id);
        $childrenIds = $this->documentRepository
            ->getByAttributes(['parent_id' => $id])
            ->pluck('id')
            ->toArray();
        $i = 0;
        while (count($childrenIds)) {
            $i++;
            $countBreak = count($childrenIds);
            $newChildrenIds = Document::whereIn('parent_id', $childrenIds)->pluck('id')->toArray();
            $childrenIds = array_unique(array_merge($childrenIds, $newChildrenIds));
            if ($countBreak == count($childrenIds) || $i == 10) break;
        }
        $slug = $document->project->slug;
        $uuid = optional($this->documentRepository->find($document->parent_id))->uuid;
        $this->documentRepository->deleteMany($childrenIds);
        $document->delete();
        toastr()->success('Document Successfully Created');

        return $uuid ?
            redirect()->route('documents.child', ['slug' => $slug, 'uuid' => $uuid]) :
            redirect()->route('documents.index', $slug);
    }
}
