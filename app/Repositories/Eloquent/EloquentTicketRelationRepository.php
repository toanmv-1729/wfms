<?php

namespace App\Repositories\Eloquent;

use App\Models\TicketRelation;
use App\Contracts\Repositories\TicketRelationRepository;

class EloquentTicketRelationRepository extends EloquentRepository implements TicketRelationRepository
{
    public function __construct(TicketRelation $model)
    {
        parent::__construct($model);
    }
}
