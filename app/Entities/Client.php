<?php

namespace Projeto\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
    	'name',
    	'responsible',
    	'email',
    	'phone',
    	'adress',
    	'obs'
    ];

    public function project()
    {
    	return $this->hasMany(Project::class);
    }
}