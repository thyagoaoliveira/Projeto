<?php

namespace Projeto\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
    	'owner_id',
    	'client_id',
    	'name',
    	'description',
    	'progress',
    	'status',
    	'due_date'
    ];

    protected $dates = ['deleted_at'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
    	return $this->hasMany(ProjectNote::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

}
