<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Contracts\Repositories\TicketRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Contracts\Repositories\SpendTimeRepository;

class TicketService
{
    protected $ticketRepository;
    protected $spendTimeRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        SpendTimeRepository $spendTimeRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->spendTimeRepository = $spendTimeRepository;
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
            $ticket = $this->ticketRepository->create([
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
            if (array_get($data, 'spend_time')) {
                $this->spendTimeRepository->create([
                    'user_id' => $user->id,
                    'project_id' => $ticket->project_id,
                    'ticket_id' => $ticket->id,
                    'spend_time' => array_get($data, 'spend_time'),
                ]);
            }
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            return false;
        }

        return true;
    }

    /**
     * Update Ticket
     * @param User $user
     * @param Ticket $ticket
     * @param array $data
     * @return Boolean
     */
    public function update(User $user, Ticket $ticket, $data)
    {
        try {
            $ticket->update([
                'team_id' => array_get($data, 'team') ?? $ticket->team_id,
                'version_id' => array_get($data, 'version') ?? $ticket->version_id,
                'ticket_parent_id' => array_get($data, 'parent') ?? $ticket->ticket_parent_id,
                'assignee_id' => array_get($data, 'assignee') ?? $ticket->assignee_id,
                'title' => array_get($data, 'title') ?? $ticket->title,
                'description' => array_get($data, 'description') ?? $ticket->description,
                'tracker' => array_get($data, 'tracker') ?? $ticket->tracker,
                'status' => array_get($data, 'status') ?? $ticket->status,
                'priority' => array_get($data, 'priority') ?? $ticket->priority,
                'start_date' => array_get($data, 'start_date') ?? $ticket->start_date,
                'due_date' => array_get($data, 'due_date') ?? $ticket->due_date,
                'estimated_time' => array_get($data, 'estimated_time') ?? $ticket->estimated_time,
                'spend_time' => (array_get($data, 'spend_time') ?? 0) + $ticket->spend_time,
                'progress' => array_get($data, 'progress') ?? $ticket->progress,
            ]);
            if (array_get($data, 'spend_time')) {
                $this->spendTimeRepository->create([
                    'user_id' => $user->id,
                    'project_id' => $ticket->project_id,
                    'ticket_id' => $ticket->id,
                    'spend_time' => array_get($data, 'spend_time'),
                ]);
            }
        } catch (Exception $exception) {
            app(ExceptionHandler::class)->report($exception);
            return false;
        }

        return true;
    }
}
