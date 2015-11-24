<?php

namespace Projeto\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
    	'name',
    	'responsible',
    	'email',
    	'phone',
    	'adress',
    	'obs'
    ];

    protected $dates = ['deleted_at'];

    public function project()
    {
    	return $this->hasMany(Project::class);
    }
}