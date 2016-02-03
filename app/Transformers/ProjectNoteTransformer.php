<?php

namespace Projeto\Transformers;

use Projeto\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{

    public function transform (ProjectNote $projectNote)
    {
        return [
            'projectNote_id' => $projectNote->id,
            'project_id' => $projectNote->project_id,
            'title' => $projectNote->title,
            'note' => $projectNote->note
        ];
    }

}
