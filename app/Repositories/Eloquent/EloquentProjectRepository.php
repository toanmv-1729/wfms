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

    /**
     * Get all projects in company
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getInCompany($companyId, $columns = ['*'])
    {
        return $this->model
            ->with('media')
            ->withCount('users')
            ->where('company_id', $companyId)
            ->get($columns);
    }
}
