<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToUser;

class Ticket extends Model
{
    use BelongsToUser, SoftDeletes;

    protected $fillable = [
        'project_id',
        'user_id',
        'company_id',
        'team_id',
        'version_id',
        'ticket_parent_id',
        'assignee_id',
        'title',
        'description',
        'tracker',
        'status',
        'priority',
        'start_date',
        'due_date',
        'estimated_time',
        'spend_time',
        'progress',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function parent()
    {
        return $this->belongsTo(Ticket::class, 'id', 'ticket_parent_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_parent_id', 'id');
    }

    public function ticketRelations()
    {
        return $this->hasMany(TicketRelation::class);
    }

    public function ticketRelationsFlip()
    {
        return $this->hasMany(TicketRelation::class, 'ticket_relation_id');
    }

    public function ticketHistories()
    {
        return $this->hasMany(TicketHistory::class);
    }
}
