<?php

namespace App\Repositories\Eloquent;

use App\Models\Ticket;
use App\Contracts\Repositories\TicketRepository;

class EloquentTicketRepository extends EloquentRepository implements TicketRepository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    /**
     * get relation ticket
     * @param int $projectId
     * @param array $notInIds
     * @param array $columns
     * @return Collection
     */
    public function getRelationTickets($projectId, $notInIds, $columns = ['*'])
    {
        return $this->model
            ->where('project_id', $projectId)
            ->whereNotIn('id', $notInIds)
            ->get($columns);
    }

    /**
     * Get by projectIds
     * @param array $projectIds
     * @param array $columns
     * @return Collection
     */
    public function getByProjectIds(array $projectIds, $columns = ['*'])
    {
        return $this->model
            ->whereIn('project_id', $projectIds)
            ->get($columns);
    }
}
