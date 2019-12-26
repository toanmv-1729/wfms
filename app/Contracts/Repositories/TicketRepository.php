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

    /**
     * Get by custom conditions filter
     * @param int $projectId
     * @param array $conditions
     * @param array $columns
     * @return [type]
     */
    public function getByCustomConditions($projectId, $conditions, $columns = ['*']);
}
