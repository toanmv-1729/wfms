<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'project_id',
        'parent_id',
        'name',
        'uuid',
        'type',
        'link',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(Document::class, 'id', 'parent_id');
    }
}
