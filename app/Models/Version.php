<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'start_date',
        'due_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
