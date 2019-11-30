<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketRelation extends Model
{
    protected $fillable = [
        'ticket_id',
        'ticket_relation_id',
    ];
}
