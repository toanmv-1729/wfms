<?php

namespace App\Contracts\Repositories;

interface RoleRepository extends Repository
{
    /**
     * Get Role By User Id
     * @param int $userId
     * @param array $columns
     * @return Collection
     */
    public function getByUserId(int $userId, $columns = ['*']);
}
