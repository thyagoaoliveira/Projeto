<?php

namespace Projeto\Transformers;

use Projeto\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    //protected $defaultIncludes = ['members', 'notes', 'tasks'];
    protected $defaultIncludes = ['members'];

    public function transform (Project $project)
    {
        return [
            'id' => $project->id,
            'project' => $project->name,
            'description' => $project->description,
            'owner_id' => $project->owner_id,
            'client_id' => $project->owner_id,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());
    }

    /*public function includeNotes(Project $project)
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeTasks(Project $project)
    {
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }*/

}
