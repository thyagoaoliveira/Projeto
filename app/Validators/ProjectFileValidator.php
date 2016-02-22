<?php

namespace Projeto\Validators;

use Prettus\Validator\LaravelValidator;


class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'name' => 'required',
		'description' => 'required',
		'extension' => 'required'
	];
}