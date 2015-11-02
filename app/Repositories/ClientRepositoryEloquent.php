<?php

namespace Projeto\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Projeto\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
	public function model()
	{
		return Client::class;
	}
}