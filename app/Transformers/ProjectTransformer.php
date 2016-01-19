<?php

namespace Projeto\Transformers;

use Projeto\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members'];

    public function transform (Project $project)
    {
        return [
            'id' => $project->id,
            'project' => $project->name,
            'description' => $project->description
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());
    }

}
