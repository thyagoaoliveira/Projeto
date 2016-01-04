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

    /**
     * [__construct description]
     * @param ProjectTaskRepository $repository [description]
     * @param ProjectTaskService    $service    [description]
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id, ProjectRepository $project)
    {
        $userId = Authorizer::getResourceOwnerId();

        if($project->isOwner($id, $userId) == false) {
            
            return ['success'=>false];
        }
        
        $result = $this->repository->findWhere(['project_id'=>$id]);

        if(isset($result) && count($result) > 0) {
            
            return $result;
        }else {

            return[ 
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }
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
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $taskId, ProjectRepository $project)
    {
        $userId = Authorizer::getResourceOwnerId();

        if($project->isOwner($id, $userId) == false) {
            
            return ['success'=>false];
        }
        
        $result = $this->repository->with('project')->findWhere(['id'=>$taskId, 'project_id'=>$id]);

        if(isset($result) && count($result) == 1) {
            
            return $result;
        }else {

            return[ 
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $taskId)
    {
        $this->repository->update($request->all(), $taskId);
        return $this->repository->find($taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($taskId)
    {
        $this->repository->find($taskId)->delete();
    }
}
