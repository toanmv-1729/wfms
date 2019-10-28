<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Contracts\Repositories\UserRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get All Staff In Company
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getStaffInCompany(int $companyId, $columns = ['*'])
    {
        return $this->model
            ->with('roles')
            ->where('company_id', $companyId)
            ->where('user_type', config('user.type.staff'))
            ->get($columns);
    }
}
