<?php

namespace App\Http\Controllers;

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

        return view('documents.index', compact('project'));
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
            $document = $this->documentRepository->create([
                'user_id' => $this->user->id,
                'project_id' => $request->project,
                'parent_id' => $request->parent,
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

        return redirect()->route('documents.index', $request->slug);
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
