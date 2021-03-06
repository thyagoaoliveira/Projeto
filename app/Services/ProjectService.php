<?php

namespace Projeto\Services;

use Projeto\Repositories\ProjectRepository;
use Projeto\Repositories\ProjectFileRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Validators\ProjectValidator;
use Projeto\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectService
{
	/**
     * [$repository description]
     * 
     * @var ProjectRepository
     */
    protected $repository;

	/**
	 * [$validator description]
	 * @var ProjectValidator
	 */
    protected $validator;


    protected $validatorFile;

    /**
     * [__construct description]
     * @param ProjectRepository $repository [description]
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage, ProjectFileValidator $validatorFile, ProjectFileRepository $fileRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->validatorFile = $validatorFile;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        $this->fileRepository = $fileRepository;
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();        
        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();        
        return $this->repository->isMember($projectId, $userId);
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
     * [create description]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function create(array $data)
    {
    	try {
    		
            $this->validator->with($data)->passesOrFail();
    		return $this->repository->create($data);
    	}
    	catch (ValidatorException $e) {
    		
            return [
    			'error' => true,
    			'message' => $e->getMessageBag()
    		];
    	}
    }

    public function update(array $data, $id)
    {
    	try {
    		
            $this->repository->find($id);
                       
            if($this->checkProjectPermissions($id))
            {
                $this->validator->with($data)->passesOrFail();
                $this->repository->update($data, $id);
                return $this->repository->find($id);
            }               
            
            return ['error'=>'Acesso negado.'];

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        
        }catch (ValidatorException $e) {
    		
            return [
    			'error' => true,
    			'message' => $e->getMessageBag()
    		];
    	}

        
    }

    public function addMember($projectId, $memberId)
    {
        if(!$this->repository->isMember($projectId, $memberId)) {

            $this->repository->find($projectId)->members()->attach($memberId);
            return $this->repository->with(['members'])->find($projectId);
        }
        else {

            return[ 
                'error' => true,
                'message' => 'Usuário já é um membro.'
            ];
        }   
    }

    public function removeMember($projectId, $memberId)
    {
        if($this->repository->isMember($projectId, $memberId)) {

            $this->repository->find($projectId)->members()->detach($memberId);
            return $this->repository->with(['members'])->find($projectId);
        }
        else {

            return[ 
                'error' => true,
                'message' => 'Membro inexistente.'
            ];
        }   
    }

    public function createFile(array $data)
    {
        /*try {
            
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $this->validatorFile->with($data)->passesOrFail();
            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));
            
        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }catch (ValidatorException $e) {
            
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }*/
        
        

        try {
            
            $this->repository->find($data['project_id']);

            if($this->checkProjectPermissions($data['project_id']))
            {
                /*$project = $this->repository->skipPresenter()->find($data['project_id']);
                $this->validatorFile->with($data)->passesOrFail();
                $projectFile = $project->files()->create($data);
                $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));
                return ['success'=>'Enviado.'];*/

                
                print_r($this->fileRepository->find(1));

                //$name = $data['project_id'].'.'.$data['extension'];
                //echo $name;
                /*$exists = $this->storage->exists('3');
                if($exists)
                {
                    return 'sim';
                }
                else
                {
                    return 'nao';
                }*/
            }               
            
            //return ['error'=>'Acesso negado.'];

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        
        }catch (ValidatorException $e) {
            
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function destroyFile(array $data)
    {
        try {
            
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $this->validatorFile->with($data)->passesOrFail();
            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));
            
        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }catch (ValidatorException $e) {
            
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

        try {

            $this->repository->find($id);
            
            if($this->checkProjectOwner($id))
            {
                $this->repository->skipPresenter(true)->find($id)->delete();
                $this->repository->skipPresenter(false);
                return 'Project_id: ' . $id . ' deletado.';
            }

            return ['error'=>'Acesso negado.'];            

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
    
}