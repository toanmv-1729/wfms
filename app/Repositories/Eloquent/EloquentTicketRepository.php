<?php

namespace App\Repositories\Eloquent;

use App\Models\Ticket;
use App\Contracts\Repositories\TicketRepository;

class EloquentTicketRepository extends EloquentRepository implements TicketRepository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }
}
