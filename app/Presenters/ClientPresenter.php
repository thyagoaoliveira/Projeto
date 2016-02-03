<?php

namespace Projeto\Presenters;

use Projeto\Transformers\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ClientPresenter extends FractalPresenter
{

    public function getTransformer ()
    {
        return new ClientTransformer();
    } 

}