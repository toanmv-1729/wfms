<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @param string $string
 * @return unique string
 */
if (!function_exists('uuid_str')) {
    function uuid_str($string)
    {
        return sprintf(
            '%s-%s-%s',
            trim($string),
            Str::uuid(),
            Carbon::now()->format('YmdHis')
        );
    }
}

function storage_url($path)
{
    if (!$path || app('url')->isValidUrl($path)) {
        return $path;
    }
    if (config('filesystems.default') === 'local' || config('filesystems.default') === 'public') {
        return app('filesystem')->url($path);
    }
}

/**
 * @param User $user
 * @return array
 */
if (!function_exists('has_permissions')) {
    function has_permissions(User $user)
    {
        if ($user->roles->count()) {
            return $user->roles[0]->permissions->pluck('name')->toArray();
        } else {
            return [];
        }
    }
}
