<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use App\Models\TicketHistory;
use App\Contracts\Repositories\TicketHistoryRepository;

class EloquentTicketHistoryRepository extends EloquentRepository implements TicketHistoryRepository
{
    public function __construct(TicketHistory $model)
    {
        parent::__construct($model);
    }

    /**
     * Get List
     * @param int $id
     * @param array $columns
     * @return Collection
     */
    public function getList($id, $columns = ['*'])
    {
        return $this->model
            ->with('user')
            ->where('ticket_id', $id)
            ->get()
            ->groupBy(function ($value) {
                return Carbon::parse($value->created_at)->format('d-m-Y H:m:i');
            });
    }
}
