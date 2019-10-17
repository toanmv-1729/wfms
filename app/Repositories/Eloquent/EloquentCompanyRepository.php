<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Contracts\Repositories\CompanyRepository;

class EloquentCompanyRepository extends EloquentRepository implements CompanyRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    public function getAllWithUsers($columns = ['*'])
    {
        return $this->model->with('users')->get($columns);
    }
}
