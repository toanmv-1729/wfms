<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'description',
        'status',
        'start_date',
        'due_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
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
}
