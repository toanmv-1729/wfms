<?php

namespace App\Contracts\Repositories;

interface RoleRepository extends Repository
{
    /**
     * Get Role By Company Id
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getByCompanyId(int $companyId, $columns = ['*']);
}
