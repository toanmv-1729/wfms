<?php

namespace App\Contracts\Repositories;

interface TicketHistoryRepository extends Repository
{
    /**
     * Get List
     * @param int $id
     * @param array $columns
     * @return Collection
     */
    public function getList($id, $columns = ['*']);
}
