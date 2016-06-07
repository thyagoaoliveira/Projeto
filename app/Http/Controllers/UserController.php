<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;
use Projeto\Repositories\UserRepository;

use Projeto\Http\Requests;
use Projeto\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository) {

        $this->repository = $repository;
    }

    public function authenticated() {

        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->find($userId);
    }
}
