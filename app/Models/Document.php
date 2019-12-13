<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use BelongsToUser;

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
