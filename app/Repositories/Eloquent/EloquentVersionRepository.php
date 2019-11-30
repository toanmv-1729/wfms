<?php

namespace App\Repositories\Eloquent;

use App\Models\Version;
use App\Contracts\Repositories\VersionRepository;

class EloquentVersionRepository extends EloquentRepository implements VersionRepository
{
    public function __construct(Version $model)
    {
        parent::__construct($model);
    }
}
