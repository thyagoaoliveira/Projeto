<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Projeto\Repositories\ProjectNoteRepository;
use Projeto\Services\ProjectNoteService;

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

    /**
     * [__construct description]
     * @param ProjectNoteRepository $repository [description]
     * @param ProjectNoteService    $service    [description]
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
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
    public function show($id, $noteId)
    {
        return $this->repository->findWhere(['project_id'=>$id, 'id'=>$noteId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, $noteId)
    {
        $this->repository->update($request->all(), $noteId);
        return $this->repository->find($noteId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $noteId)
    {
        $this->repository->find($noteId)->delete();
    }
}
