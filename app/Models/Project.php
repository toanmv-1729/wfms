<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'root_folder_link',
        'repository_link',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role_id');
    }

    public function positions($pivotId)
    {
        return $this->belongsToMany(User::class)->withPivot('role_id')->where('role_id', $pivotId);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketsClosed()
    {
        return $this->hasMany(Ticket::class)->where('status', 6);
    }

    public function tasks()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 1);
    }

    public function tasksClosed()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 1)->where('status', 6);
    }

    public function bugs()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 2);
    }

    public function bugsClosed()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 2)->where('status', 6);
    }

    public function features()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 3);
    }

    public function featuresClosed()
    {
        return $this->hasMany(Ticket::class)->where('tracker', 3)->where('status', 6);
    }

    public function getProjectManager()
    {
        return $this->users()
            ->withPivot('role_id')
            ->join('roles', 'project_user.role_id', '=', 'roles.id')
            ->where('roles.name', 'Product Owner')
            ->first();
    }
}
