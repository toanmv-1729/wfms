<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Contracts\Repositories\TicketRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;

class TicketService
{
    protected $ticketRepository;

    public function __construct(
        TicketRepository $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Store Ticket
     * @param User $user
     * @param array $data
     * @return Boolean
     */
    public function store(User $user, $data)
    {
        try {
            $this->ticketRepository->create([
                'project_id' => array_get($data, 'pid'),
                'user_id' => $user->id,
                'company_id' => $user->company_id,
                'team_id' => array_get($data, 'team'),
                'version_id' => array_get($data, 'version'),
                'ticket_parent_id' => array_get($data, 'parent'),
                'assignee_id' => array_get($data, 'assignee'),
                'title' => array_get($data, 'title'),
                'description' => array_get($data, 'description'),
                'tracker' => array_get($data, 'tracker'),
                'status' => array_get($data, 'status'),
                'priority' => array_get($data, 'priority'),
                'start_date' => array_get($data, 'start_date'),
                'due_date' => array_get($data, 'due_date'),
                'estimated_time' => array_get($data, 'estimated_time'),
                'spend_time' => array_get($data, 'spend_time'),
                'progress' => array_get($data, 'progress'),
            ]);
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            return false;
        }

        return true;
    }
}
