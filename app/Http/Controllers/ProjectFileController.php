<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Repositories\ProjectRepository;
use Projeto\Repositories\ProjectFileRepository;
use Projeto\Services\ProjectFileService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProjectFileController extends Controller
{
    /**
     * [$repository description]
     * 
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * [$service description]
     * @var ProjectFileService
     */
    private $service;

    /**
     * [$service description]
     * @var ProjectRepository
     */
    private $project;

    /**
     * [__construct description]
     * @param ProjectRepository $repository [description]
     * @param ProjectService    $service    [description]
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service, ProjectRepository $project)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->project = $project;
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();        
        return $this->project->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();        
        return $this->project->isMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        if(count($request->file('file')))
        {
            $file = $request->file('file');
            /*$existe = Storage::exists('2.jpg');
            if($existe)
            {
                return Storage::size('2.jpg');
            }*/            
            
            $extension = $file->getClientOriginalExtension();

            $data['file'] = $file;
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['description'] = $request->description;
            $data['project_id'] = $projectId;

            return $this->service->create($data);
        }

        return ['error'=>'Arquivo não selecionado.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId, $fileId)
    {
         return $this->service->destroy($projectId, $fileId);
    }

}
