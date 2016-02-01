<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Projeto\Repositories\ProjectNoteRepository;
use Projeto\Repositories\ProjectRepository;
use Projeto\Services\ProjectNoteService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectNoteController extends Controller
{
    /**
     * [$repository description]
     * 
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * [$service description]
     * @var ProjectNoteService
     */
    private $service;


    private $project;

    /**
     * [__construct description]
     * @param ProjectNoteRepository $repository [description]
     * @param ProjectNoteService    $service    [description]
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectRepository $project)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        //return $this->repository->findWhere(['project_id'=>$id]);
        return $this->project->skipPresenter(true)->with(['notes'])->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Não vai precisar por ora.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        return $this->service->create($request->all(), $projectId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($projectId, $noteId)
    {
        //return $this->repository->findWhere(['project_id'=>$id, 'id'=>$noteId]);
        return $this->service->show($projectId, $noteId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $projectId, $noteId)
    {
        return $this->service->update($request->all(), $projectId, $noteId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId, $noteId)
    {
        return $this->service->destroy($projectId, $noteId);
    }
}
