<?php

namespace App\Repositories\Eloquent;

use App\Models\SampleDescription;
use App\Contracts\Repositories\SampleDescriptionRepository;

class EloquentSampleDescriptionRepository extends EloquentRepository implements SampleDescriptionRepository
{
    public function __construct(SampleDescription $model)
    {
        parent::__construct($model);
    }
}
