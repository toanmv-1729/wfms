<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Validation\Rule;
use App\Rules\CheckAllowRelationTicket;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\Repositories\TicketRepository;

class AddRelationTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $relationTicketIds = $this->relation_tickets;
        $ticket = app(TicketRepository::class)->findOrFail($this->tid);
        $allowTicketIds = $ticket->project->tickets->pluck('id')->toArray();

        return [
            'tid' => [
                'required',
                'integer',
                Rule::notIn($relationTicketIds),
                Rule::in($allowTicketIds),
            ],
            'relation_tickets' => [
                'required',
                'array',
                new CheckAllowRelationTicket($this->relation_tickets, $allowTicketIds),
            ],
        ];
    }

    public function messages()
    {
        return [
            'tid.*' => 'Add relation ticket error!',
            'relation_tickets.*' => 'Add relation ticket error!',
        ];
    }
}
