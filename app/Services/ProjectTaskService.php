<?php

namespace Projeto\Services;

use Projeto\Repositories\ProjectTaskRepository;
use Projeto\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
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
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
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
    		return $this->repository->update($data, $id);
    	}
    	catch (ValidatorException $e) {
    		return [
    			'error' => true,
    			'message' => $e->getMessageBag()
    		];
    	}    	
    }
}