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

    /**
     * Get by custom conditions filter
     * @param int $projectId
     * @param array $conditions
     * @param array $columns
     * @return [type]
     */
    public function getByCustomConditions($projectId, $conditions, $columns = ['*'])
    {
        return $this->model
            ->where('project_id', $projectId)
            ->when(array_get($conditions, 'tracker'), function ($query) use ($conditions) {
                $query->whereIn('tracker', array_get($conditions, 'tracker'));
            })
            ->when(array_get($conditions, 'status'), function ($query) use ($conditions) {
                $query->whereIn('status', array_get($conditions, 'status'));
            })
            ->when(array_get($conditions, 'priority'), function ($query) use ($conditions) {
                $query->whereIn('priority', array_get($conditions, 'priority'));
            })
            ->when(array_get($conditions, 'assignee'), function ($query) use ($conditions) {
                $query->whereIn('assignee_id', array_get($conditions, 'assignee'));
            })
            ->when(array_get($conditions, 'version'), function ($query) use ($conditions) {
                $query->whereIn('version_id', array_get($conditions, 'version'));
            })
            ->with(['user', 'team', 'version', 'assignee'])
            ->get($columns);
    }
}
