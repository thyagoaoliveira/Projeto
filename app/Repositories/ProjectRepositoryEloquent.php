<?php

namespace Projeto\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Projeto\Repositories\ProjectRepository;
use Projeto\Entities\Project;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace Projeto\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function isOwner($projectId, $userId)
    {
        if(count($this->findwhere(['id' => $projectId, 'owner_id' => $userId])))
        {
            return true;
        }
        return false;
    }

    public function isMember($projectId, $memberId)
    {
        if(count($this->findwhere(['id' => $projectId, 'members' => $memberId])))
        {
            return true;
        }
        return false;
    }
}
