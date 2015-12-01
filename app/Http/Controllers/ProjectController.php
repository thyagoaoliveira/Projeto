<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Repositories\ProjectRepository;
use Projeto\Services\ProjectService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectController extends Controller
{
    /**
     * [$repository description]
     * 
     * @var ClientRepository
     */
    private $repository;

    /**
     * [$service description]
     * @var ProjectService
     */
    private $service;

    /**
     * [__construct description]
     * @param ProjectRepository $repository [description]
     * @param ProjectService    $service    [description]
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->with(['owner', 'client'])->all();
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
    public function show($id)
    {
        try {
            
            $userId = Authorizer::getResourceOwnerId();
            if($this->repository->isOwner($id, $userId) == false) {
                return ['success'=>false];
            }

            return $this->repository->with(['owner', 'client'])->find($id);
        
        }catch (ModelNotFoundException $e) {
            
            return [
                'error' => true,
                'message' => $e->getMessage()
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
    public function update(Request $request, $id)
    {
        try {

            $this->repository->update($request->all(), $id);
            return $this->repository->find($id);

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {

            $this->repository->find($id)->delete();

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
