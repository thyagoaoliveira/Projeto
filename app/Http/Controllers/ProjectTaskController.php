<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Projeto\Repositories\ProjectTaskRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Services\ProjectTaskService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Projeto\Repositories\ProjectRepository;

class ProjectTaskController extends Controller
{
    /**
     * [$repository description]
     * 
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * [$service description]
     * @var ProjectTaskService
     */
    private $service;


    private $project;

    /**
     * [__construct description]
     * @param ProjectTaskRepository $repository [description]
     * @param ProjectTaskService    $service    [description]
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectRepository $project)
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
    public function index()
    {
        return $this->project->skipPresenter(true)->with(['tasks'])->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
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
    public function show($projectId, $taskId)
    {
        return $this->service->show($projectId, $taskId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $projectId, $taskId)
    {
        return $this->service->update($request->all(), $projectId, $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId, $taskId)
    {
        return $this->service->destroy($projectId, $taskId);
    }
}
