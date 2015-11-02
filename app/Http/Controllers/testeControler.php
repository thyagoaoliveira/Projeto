<?php

namespace Projeto\Http\Controllers;

use Illuminate\Http\Request;

use Projeto\Http\Requests;
use Projeto\Http\Controllers\Controller;

class testeControler extends Controller
{
    public function index($nome)
    {
        return view('teste/index', ['nome'=>$nome]);
    }

    public function notas()
    {
        $notas = [
        	0 => 'Anotacao 1',
        	1 => 'Anotacao 2',
        	2 => 'Anotacao 3',
        	3 => 'Anotacao 4',
        	4 => 'Anotacao 5'
        ];
        return view('teste/notas', compact('notas'));
    }
}