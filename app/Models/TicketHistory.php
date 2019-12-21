<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'content',
        'note',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
