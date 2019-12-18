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
     * Get Role By Company Id
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getByCompanyId(int $companyId, $columns = ['*'])
    {
        return $this->model
            ->with('permissions')
            ->where('company_id', $companyId)
            ->get($columns);
    }
}
