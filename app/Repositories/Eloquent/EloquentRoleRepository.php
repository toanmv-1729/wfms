<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Contracts\Repositories\RoleRepository;

class EloquentRoleRepository extends EloquentRepository implements RoleRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Role By User Id
     * @param int $userId
     * @param array $columns
     * @return Collection
     */
    public function getByUserId(int $userId, $columns = ['*'])
    {
        return $this->model
            ->with('permissions')
            ->where('user_id', $userId)
            ->get($columns);
    }
}
