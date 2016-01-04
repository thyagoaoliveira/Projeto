<?php

namespace Projeto\Validators;

use Prettus\Validator\LaravelValidator;


class ProjectValidator extends LaravelValidator
{
	protected $rules = [
		'owner_id' => 'required|integer',
		'client_id' => 'required|integer',
		'name' => 'required',
		'progress' => 'required|integer',
		'status' => 'required',
		'due_date' => 'required',
	];
}