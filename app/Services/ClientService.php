<?php

namespace Projeto\Services;

use Projeto\Repositories\ClientRepository;
use Projeto\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
	/**
     * [$repository description]
     * 
     * @var ClientRepository
     */
    protected $repository;

	/**
	 * [$validator description]
	 * @var ClientValidator
	 */
    protected $validator;

    /**
     * [__construct description]
     * @param ClientRepository $repository [description]
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)
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

    	}catch (ValidatorException $e) {
    		
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
    	
        }catch (ValidatorException $e) {
    		
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
    	}	
    }
}