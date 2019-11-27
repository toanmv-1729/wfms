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
    public function getInCompany($companyId, $itemPerPage = 1, $columns = ['*'])
    {
        return $this->model
            ->select($columns)
            ->with('media')
            ->withCount('users')
            ->where('company_id', $companyId)
            ->paginate($itemPerPage);
    }
}
