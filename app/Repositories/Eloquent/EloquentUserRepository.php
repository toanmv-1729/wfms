<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Contracts\Repositories\UserRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
