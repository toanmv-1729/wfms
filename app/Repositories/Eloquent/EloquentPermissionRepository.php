<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Contracts\Repositories\PermissionRepository;

class EloquentPermissionRepository extends EloquentRepository implements PermissionRepository
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
