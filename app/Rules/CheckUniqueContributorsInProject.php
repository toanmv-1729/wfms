<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckUniqueContributorsInProject implements Rule
{
    protected $users;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
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
        return count($this->users) &&
            (count(array_flatten($this->users)) === count(array_unique(array_flatten($this->users))));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One person can only hold one position in one project';
    }
}
