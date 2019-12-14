<?php

namespace App\Repositories\Eloquent;

use App\Models\SpendTime;
use App\Contracts\Repositories\SpendTimeRepository;

class EloquentSpendTimeRepository extends EloquentRepository implements SpendTimeRepository
{
    public function __construct(SpendTime $model)
    {
        parent::__construct($model);
    }
}
