<?php

namespace Projeto\Services;

use Projeto\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Projeto\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

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

    /**
     * [__construct description]
     * @param ProjectRepository $repository [description]
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
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
    		
            $this->validator->with($data)->passesOrFail();
            $this->repository->update($data, $id);            
            return $this->repository->find($id);

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
    
}