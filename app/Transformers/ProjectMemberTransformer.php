<?php

namespace Projeto\Transformers;

use Projeto\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    public function transform (User $member)
    {
        return [
            'member' => $member->name
        ];
    } 

}
