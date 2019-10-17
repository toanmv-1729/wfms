<?php

use Carbon\Carbon;
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
