<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpendTime extends Model
{
    use SoftDeletes, BelongsToUser;

    protected $fillable = [
        'user_id',
        'project_id',
        'ticket_id',
        'spend_time',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
