<?php

namespace App\Repositories\Eloquent;

use App\Models\Team;
use App\Contracts\Repositories\TeamRepository;

class EloquentTeamRepository extends EloquentRepository implements TeamRepository
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }
}
