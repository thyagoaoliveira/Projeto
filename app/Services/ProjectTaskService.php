<?php

namespace Projeto\Services;

use Projeto\Repositories\ProjectTaskRepository;
use Projeto\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTaskService
{
    /**
     * [$repository description]
     * 
     * @var ProjectRepository
     */
    protected $repository;

    protected $project;

    /**
     * [$validator description]
     * @var ProjectValidator
     */
    protected $validator;

    /**
     * [__construct description]
     * @param ProjectRepository $repository [description]
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator, ProjectRepository $project)
    {
        $this->repository = $repository;
        $this->project = $project;
        $this->validator = $validator;
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

    public function index($projectId)
    {
        try {
            
            if($this->checkProjectPermissions($projectId))
            {
                return $this->repository->findwhere(['project_id' => $projectId]);
            }               
            
            return ['error'=>'Acesso negado.'];

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        
        }
    }

    /**
     * [create description]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function create(array $data, $projectId)
    {
        try {
            
            if($this->checkProjectPermissions($projectId))
            {
                if($data['project_id'] == $projectId)
                {
                    $this->validator->with($data)->passesOrFail();
                    return $this->repository->create($data);
                }

                return ['error'=>'ID divergente do Projeto.'];                
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

    public function show($projectId, $taskId)
    {
        try {

            if($this->checkProjectPermissions($projectId))
            {
                $result = $this->repository->skipPresenter(true)->findwhere(['id' => $taskId, 'project_id' => $projectId]);
                $this->repository->skipPresenter(false);

                if(count($result))
                {               
                    return $this->repository->findwhere(['id' => $taskId, 'project_id' => $projectId]);
                }

                return ['error'=>'Task não encontrada neste Projeto.'];
            }               
            
            return ['error'=>'Acesso negado.'];

        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        
        }
    }

    public function update(array $data, $projectId, $taskId)
    {
        try {

            if($this->checkProjectPermissions($projectId))
            {
                $result = $this->repository->skipPresenter(true)->findwhere(['id' => $taskId, 'project_id' => $projectId]);
                $this->repository->skipPresenter(false);
                
                if(count($result))
                {                    
                    if($data['project_id'] == $projectId)
                    {
                        $this->validator->with($data)->passesOrFail();
                        $this->repository->update($data, $taskId);
                        return $this->repository->find($taskId);                        
                    }
                    
                    return ['error'=>'ID da Task divergente.'];
                }

                return ['error'=>'Task não encontrada neste Projeto.'];
            }               
            
            return ['error'=>'Acesso negado.'];

        }catch (ValidatorException $e) {
                    
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        
        }catch(ModelNotFoundException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        
        }
        
    }

    public function destroy($projectId, $taskId)
    {              
        
        try {

            if($this->checkProjectPermissions($projectId))
            {
                $result = $this->repository->skipPresenter(true)->findwhere(['id' => $taskId, 'project_id' => $projectId]);
                
                if(count($result))
                {                    
                    $this->repository->find($taskId)->delete();
                    $this->repository->skipPresenter(false);             
                    return ['success'=>'Deletado.'];
                }

                return ['error'=>'Task não encontrada neste Projeto.'];
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