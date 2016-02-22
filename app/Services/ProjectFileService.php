<?php

namespace Projeto\Services;

use Projeto\Repositories\ProjectRepository;
use Projeto\Repositories\ProjectFileRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileService
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

    /**
     * [$validator description]
     * @var ProjectRepository
     */
    protected $project;

    /**
     * [__construct description]
     * @param ProjectFileRepository $repository [description]
     */
    public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository, Filesystem $filesystem, Storage $storage, ProjectFileValidator $validator)
    {
        $this->repository = $repository;
        $this->project = $projectRepository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
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
     * [create description]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function create(array $data)
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
            
            $this->project->find($data['project_id']);

            if($this->checkProjectPermissions($data['project_id']))
            {
                $result =  $this->repository->findWhere(['project_id'=>$data['project_id'], 'name'=>$data['name']]);

                if(!count($result))
                {
                    $this->validator->with($data)->passesOrFail();
                    $this->repository->create($data);
                    $this->storage->put($data['project_id'].'.'.$data['extension'], $this->filesystem->get($data['file']));
                    return ['success'=>'Enviado.'];
                }
                return ['error'=>'Arquivo já pertence ao projeto.'];
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

    public function destroy($projectId, $fileId)
    {
        try {

            $this->project->find($projectId);

            if($this->checkProjectPermissions($projectId))
            {
                $result = $this->repository->skipPresenter(true)->findwhere(['id' => $fileId, 'project_id' => $projectId]);
                               
                if(count($result))
                {
                    $file = $this->repository->find($fileId);
                    $name = $file->project_id.'.'.$file->extension;                    

                    if($this->storage->exists($name))
                    {
                        $this->repository->find($fileId)->delete();
                        $this->storage->delete($name);
                        $this->repository->skipPresenter(false);
                        return ['success'=>'Arquivo deletado.'];
                    }

                    return ['error'=>'Falha ao deletar arquivo.'];
                }

                return ['error'=>'Arquivo não encontrado neste Projeto.'];
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