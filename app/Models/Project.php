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

    public function getProjectManager()
    {
        return $this->users()
            ->withPivot('role_id')
            ->join('roles', 'project_user.role_id', '=', 'roles.id')
            ->where('roles.name', 'Product Owner')
            ->first();
    }
}
