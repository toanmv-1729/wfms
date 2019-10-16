<?php

namespace App\Models\Traits\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToUser
{
    /**
     * Get the user that owns the object.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
