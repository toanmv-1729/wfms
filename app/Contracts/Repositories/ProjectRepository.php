<?php

namespace App\Contracts\Repositories;

interface ProjectRepository extends Repository
{
    /**
     * Get all projects in company
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getInCompany($companyId, $columns = ['*']);
}
