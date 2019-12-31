<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckRequiredProductOwnerProject implements Rule
{
    protected $user;
    protected $users;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user, $users)
    {
        $this->user = User::where([
            'user_type' => 'company',
            'company_id' => $user->company_id,
        ])->first();
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
        $roleProductOwnerId = $this->user->hasRoles()->where('name', 'Product Owner')->first()->id;

        return in_array($roleProductOwnerId, array_keys($this->users));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product Owner cannot be blank!';
    }
}
