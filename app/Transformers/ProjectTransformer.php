<?php

namespace Projeto\Transformers;

use Projeto\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    public function transform (Project $project)
    {
        return [
            'id' => $project->id,
            'project' => $project->name,
            'description' => $project->description
        ];
    } 

}
