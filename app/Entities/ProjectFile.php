<?php

namespace Projeto\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectFile extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
    	'name',
    	'description',
    	'extension'
    ];

    public function client()
    {
    	return $this->belongsTo(Project::class);
    }

}