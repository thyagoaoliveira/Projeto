<?php

namespace Projeto\Transformers;

use Projeto\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

class ProjectTaskTransformer extends TransformerAbstract
{

    public function transform (ProjectTask $projectTask)
    {
        return [
            'projectTask_id' => $projectTask->id,
            'project_id' => $projectTask->project_id,
            'name' => $projectTask->name,
            'start_date' => $projectTask->start_date,
            'due_date' => $projectTask->due_date,
            'status' => $projectTask->status
        ];
    }

}
