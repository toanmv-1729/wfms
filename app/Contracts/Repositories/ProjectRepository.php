<?php

namespace App\Contracts\Repositories;

interface ProjectRepository extends Repository
{
    /**
     * Get all projects in company
     * @param int $companyId
     * @param int $itemPerPage
     * @param array $columns
     * @return Collection
     */
    public function getInCompany($companyId, $itemPerPage = 8, $columns = ['*']);

    /**
     * Get project infomation
     * @param string $slug
     * @param array $columns
     * @return Object
     */
    public function getProjectInfo($slug, $columns = ['*']);
}
