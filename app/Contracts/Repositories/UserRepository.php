<?php

namespace App\Contracts\Repositories;

interface UserRepository extends Repository
{
    /**
     * Get All Staff In Company
     * @param int $companyId
     * @param array $columns
     * @return Collection
     */
    public function getStaffInCompany(int $companyId, $columns = ['*']);
}
