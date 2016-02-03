<?php

namespace Projeto\Presenters;

use Projeto\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectTaskPresenter extends FractalPresenter
{

    public function getTransformer ()
    {
        return new ProjectTaskTransformer();
    } 

}