<?php

namespace Projeto\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Criteria\RequestCriteria;
use Projeto\Repositories\ProjectRepository;
use Projeto\Entities\Project;
use Projeto\Presenters\ProjectPresenter;

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
        if(count($this->skipPresenter(true)->findwhere(['id' => $projectId, 'owner_id' => $userId])))
        {
            $this->skipPresenter(false);
            return true;
        }

        return false;
    }

    public function isMember($projectId, $memberId)
    {
        $result = $this->skipPresenter(true)->find($projectId)->members()->where('user_id', $memberId)->get();

        if(isset($result) && count($result) == 1) {
            
            $this->skipPresenter(false);
            return true;
        
        }else {

            return false;
        
        }

        /*$project = $this->find($projectId);

        foreach ($project->members as $member)
        {
            if($member->id == $memberId)
            {
                return true;
            }
        }

        return false;*/
    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }
}
