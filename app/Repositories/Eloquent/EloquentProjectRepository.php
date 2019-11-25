<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Contracts\Repositories\ProjectRepository;

class EloquentProjectRepository extends EloquentRepository implements ProjectRepository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }
}
