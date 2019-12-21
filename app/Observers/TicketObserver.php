<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Traits\TracksHistoryTrait;

class TicketObserver
{
    use TracksHistoryTrait;

    /**
     * Handle the role "updated" event.
     *
     * @param  \App\Models\Ticket  $role
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        $this->track($ticket);
    }
}
