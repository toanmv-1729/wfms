<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleDescription extends Model
{
    use SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'description',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
