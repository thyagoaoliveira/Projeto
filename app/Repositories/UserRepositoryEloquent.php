<?php

namespace Projeto\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Projeto\Entities\User;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
	public function model()
	{
		return User::class;
	}
}