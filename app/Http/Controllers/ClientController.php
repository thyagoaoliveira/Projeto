<?php

namespace Projeto\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Repositories\ClientRepository;
use Projeto\Services\ClientService;

class ClientController extends Controller
{
    /**
     * [$repository description]
     * 
     * @var ClientRepository
     */
    private $repository;

    /**
     * [$service description]
     * @var ClientService
     */
    private $service;

    /**
     * [__construct description]
     * @param ClientRepository $repository [description]
     * @param ClientService    $service    [description]
     */
    public function __construct(ClientRepository $repository, ClientService $service)
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
        return $this->repository->all();
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

            return $this->repository->find($id);

        }catch(ModelNotFoundException $e) {

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
