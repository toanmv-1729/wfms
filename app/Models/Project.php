<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'company_id',
        'name',
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
}
