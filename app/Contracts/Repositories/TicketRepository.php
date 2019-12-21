<?php

namespace App\Contracts\Repositories;

interface TicketRepository extends Repository
{
    /**
     * get relation ticket
     * @param int $projectId
     * @param array $notInIds
     * @param array $columns
     * @return Collection
     */
    public function getRelationTickets($projectId, $notInIds, $columns = ['*']);

    /**
     * Get by projectIds
     * @param array $projectIds
     * @param array $columns
     * @return Collection
     */
    public function getByProjectIds(array $projectIds, $columns = ['*']);
}
