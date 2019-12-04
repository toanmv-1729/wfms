<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckAllowRelationTicket implements Rule
{
    protected $ticketIds;
    protected $allowTicketIds;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $ticketIds, array $allowTicketIds)
    {
        $this->ticketIds = $ticketIds;
        $this->allowTicketIds = $allowTicketIds;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return count(array_intersect($this->ticketIds, $this->allowTicketIds)) == count($this->ticketIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Add relation ticket error!';
    }
}
