<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Traits\TracksHistoryTrait;
use App\Notifications\NewTicketNotification;
use App\Notifications\UpdatedTicketNotification;

class TicketObserver
{
    use TracksHistoryTrait;

    /**
     * Handle the role "updated" event.
     *
     * @param  \App\Models\Ticket  $role
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $user = $ticket->assignee;
        $ticketType = config('ticket.tracker')[$ticket->tracker]['name'];
        $user->notify(new NewTicketNotification($ticket->id, $ticketType, $ticket->title));
    }

    /**
     * Handle the role "updated" event.
     *
     * @param  \App\Models\Ticket  $role
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        $this->track($ticket);
        $user = $ticket->assignee;
        $ticketType = config('ticket.tracker')[$ticket->tracker]['name'];
        $user->notify(new UpdatedTicketNotification($ticket->id, $ticketType, $ticket->title));
    }
}
