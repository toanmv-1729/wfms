<?php

namespace App\Repositories\Eloquent;

use App\Models\TicketHistory;
use App\Contracts\Repositories\TicketHistoryRepository;

class EloquentTicketHistoryRepository extends EloquentRepository implements TicketHistoryRepository
{
    public function __construct(TicketHistory $model)
    {
        parent::__construct($model);
    }
}
