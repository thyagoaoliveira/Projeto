<?php

namespace Projeto\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Projeto\Entities\Client;
use Projeto\Presenters\ClientPresenter;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
	public function model()
	{
		return Client::class;
	}

	public function presenter()
    {
        return ClientPresenter::class;
    }
}