<?php

namespace App\Contracts\Repositories;

interface TicketRepository extends Repository
{
    /**
     * get relation ticket
     * @param int $projectId
     * @param int $id
     * @param array $columns
     * @return Collection
     */
    public function getRelationTickets($projectId, $id, $columns = ['*']);
}
